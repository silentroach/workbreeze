<?

class Parser {

	private $db;

	private $collection;
	private $parserId;
	private $lastJobId;

	public function __construct($db) {
		$this->db = $db;
		$this->collection = $this->db->parsers;

		$this->init();
	}

	protected function checkJob($info = array()) {
		$id = isset($info['id']) ? intval($info['id']) : -1;

		if ($id < 0)
			return false;

		if ($id <= $this->lastJobId)
			return false;

		$this->db->jobs->insert(array(
			'site' => $this->parserId,
			'id'   => $info['id'],
			'url'  => $info['url'],
			'name' => $info['name']
		));

		$this->collection->update(
			array('_id' => $this->parserId),
			array('$set' => array('lastjobid' => $id))
		);

		return true;
	}

	private function log($message = '') {
		if ('' === $message) {
			return true;
		}

		$m = $this->db->log->findOne(array(
			'site' => $this->parserId,
			'message' => $message
		));

		if (null === $m) {
			$this->db->log->insert(array(
				'site' => $this->parserId,
				'stamp' => time(),
				'message' => $message
			));

			echo '[' . $this->getCode() . '] ' . $message . "\n";
		} else {
			$this->db->log->update(
				array('_id', $m['_id']),
				array('$set' => array('stamp' => time()))
			);
		}
	}

	protected function checkCategories($cat = array()) {
		$result = array();

		$c = $this->db->catmap;

		foreach($cat as $key => $catname) {
			$map = $c->findOne(array(
				'site' => $this->parserId,
				'cat' => $key
			));

			if (null !== $map) {
				$result[] = $map['map'];
			} else {
				$message = 'Unhandled category ' . $catname . ' (' . $key . ')';

				$this->log($message);
			}
		}

		return array_unique($result);
	}

	private function init() {
		$code = $this->getCode();
		$name = $this->getName();

		if (!$code) {
			throw new Exception('Parser code is not defined');
		}

		if (!$name) {
			throw new Exception('Parser name is not defined');
		}

		$c = $this->collection;

		$doc = $c->findOne(array(
			'code' => $this->getCode()
		));

		$this->parserId = $doc['_id'];
		$this->lastJobId = isset($doc['lastjobid']) ? $doc['lastjobid'] : 0;

		if (null === $doc) {
			$obj = array(
				'code' => $code,
				'name' => $name
			);

			$c->insert($obj);

			$this->parserId = $obj['_id'];
		} else {
			$c->update(
				array('_id' => $this->parserId),
				array('$set' => array('name' => $name))
			);
		}
	}

	protected function getBaseUrl() {
		return '';
	}

	public function getName() {
		return false;
	}

	public function getCode() {
		return false;
	}

	protected function getJobPage($page = 0) {
		return false;
	}

	protected function processJobPage($page = '') {
		return false;
	}

	public function processJobs() {
		$pageNum = 0;

		echo "Parsing first page...\n";

		$page = $this->getJobPage();

		if (!$page) {
			return true;
		}

		while (
			$this->processJobPage($page)
			&& $pageNum < 4
		) {
			$pageNum++;

			echo 'Parsing page ' . $pageNum . "...\n";

			$page = $this->getJobPage($pageNum);

			if (!$page) {
				break;
			}
		}
	}

}

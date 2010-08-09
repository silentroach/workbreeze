<?

class Parser {

	private $db;
	private $doc;

	public function __construct($db) {
		$this->db = $db;

		$this->checkParser();
	}

	protected function checkJob($info = array()) {
		$id = isset($info['id']) ? intval($info['id']) : -1;

		if ($id < 0)
			return false;

		if ($id <= $this->lastJobId())
			return false;

		$this->db->jobs->insert(array(
			'site' => $this->getCode(),
			'id'   => $info['id'],
			'url'  => $info['url'],
			'name' => $info['name']
		));

		$this->doc['lastjobid'] = $id;
		$this->db->parsers->save($this->doc);

		return true;
	}

	private function lastJobId() {
		if (isset($this->doc['lastjobid'])) {
			return $this->doc['lastjobid'];
		} else
			return 0;
	}

	private function lastCheckStamp() {
		if (isset($this->doc['lastcheck'])) {
			return $this->doc['lastcheck'];
		} else 
			return 0;
	}

	private function updateDoc() {
		$this->doc = $this->db->parsers->findOne(array(
			'code' => $this->getCode()
		));
	}

	private function log($message = '') {
		if ('' === $message) {
			return true;
		}

		$m = $this->db->log->findOne(array(
			'site' => $this->getCode(),
			'message' => $message
		));

		if (null === $m) {
			$this->db->log->insert(array(
				'site' => $this->getCode(),
				'stamp' => time(),
				'message' => $message
			));

			echo '[' . $this->getCode() . '] ' . $message . "\n";
		} else {
			$this->db->log->update(
				array('_id', $m['_id']),
				array('$set', array('stamp' => time()))
			);
		}
	}

	protected function checkCategories($cat = array()) {
		$result = array();

		$c = $this->db->catmap;

		foreach($cat as $key => $catname) {
			$map = $c->findOne(array(
				'site' => $this->doc['_id'],
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

	private function checkParser() {
		$code = $this->getCode();
		$name = $this->getName();

		if (!$code) {
			throw new Exception('Parser code is not defined');
		}

		if (!$name) {
			throw new Exception('Parser name is not defined');
		}

		$c = $this->db->parsers;

		$this->updateDoc();

		if (null === $this->doc) {
			$c->insert(
				array(
					'code' => $code,
					'name' => $name
				)
			);

			return true;
		}

		if ($this->doc['name'] != $name) {
			$this->doc['name'] = $name;
			$c->save($this->doc);
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

		$page = $this->getJobPage();

		if (!$page) {
			return true;
		}

		while (
			$this->processJobPage($page)
			&& $pageNum < 4
		) {
			$pageNum++;

			$page = $this->getJobPage($pageNum);

			if (!$page) {
				break;
			}
		}
	}

}

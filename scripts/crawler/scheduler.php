<?

require 'parser.php';

class Scheduler {

	private $db;
	private $parsers;

	public function __construct($db) {
		$this->db = $db;
	}
	
	private function initParser($info) {
		if (!isset($this->parsers[$info['code']])) {	
			require('parsers/' . $info['script']);	
			$this->parsers[$info['code']] = new $info['class']($this->db);
		}
		
		return $this->parsers[$info['code']];
	}

	public function processJobList() {
		$c = $this->db->sites->find();
		
		while ($site = $c->getNext()) {			
			$parser = $this->initParser($site);
			
			echo 'Process main pages for ' . $site['name'] . "\n";
			
			$parser->processJobList();
		}
	}
	
	public function processQueue() {
		$queue = $this->db->queue;
		$sites = $this->db->sites;
		
		$c = $queue->find()->sort(array('$random' => 1))->limit(10);
		
		while ($item = $c->getNext()) {
			$site = $sites->findOne(array('code' => $item['site']));
			
			if (null === $site)
				continue;
				
			$parser = $this->initParser($site);
			
			if ('job' === $item['type']) {
				if ($parser->processJob($item['id'], $item['url'])) {
					$queue->remove(array('_id' => $item['_id']));	
				}
			}
		}
	}

}

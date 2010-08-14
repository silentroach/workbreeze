<?

require 'parser.php';

class Scheduler {

	private $db;

	private $sites;

	public function __construct($db) {
		$this->db = $db;
		
		$this->sites = $db->sites;
	}

	public function processJobList() {
		$c = $this->sites->find();
		
		while ($site = $c->getNext()) {
			require('parsers/' . $site['script']);
			
			$parser = new $site['class']($this->db);
			
			echo 'Process main pages for ' . $site['name'] . "\n";
			
			$parser->processJobList();
		}
	}

}

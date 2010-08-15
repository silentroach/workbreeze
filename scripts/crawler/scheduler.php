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
	
	private function makeTodaySchedule($code) {
		$final = 23 * 60 + 58;
	
		$i = 0;
		
		while ($i < $final) {
			$this->db->stoday->insert(array(
				'site' => $code,
				'time' => $i
			));
			
			$i = $i + 2;		
		}
	}

	public function processJobList() {
		$c = $this->db->sites->find();
		
		while ($site = $c->getNext()) {					
			$parser = $this->initParser($site);

			$time = date('G') * 60 + date('i');
		
			$tmp = $this->db->stoday->
				find(array(
					'site' => $parser->getSiteCode()
				))->
				sort(array(
					'time' => 1
				))->
				limit(1);
	
			if ($rec = $tmp->getNext()) {
				if ($rec['time'] >= $time)
					// 'tis not the time to start
					continue;		
			} else
				$this->makeTodaySchedule($parser->getSiteCode());
			
			echo 'Process main pages for ' . $site['name'] . "\n";
			
			$parser->processJobList();
			
			if ($parser->getQueuedCount() > 0) {
				$this->db->slog->remove(array(
					'site'  => $parser->getSiteCode(),
					'wyear' => array('$lt' => date('W'))
				));
			
				$this->db->slog->insert(array(
					'site'  => $parser->getSiteCode(),
					'wday'  => date('N'),
					'wyear' => date('W'),
					'time'  => date('G') * 60 + date('i'),
					'count' => $parser->getQueuedCount()
				));
			}
			
			$this->db->stoday->remove(array(
				'site' => $parser->getSiteCode(),
				'time' => array('$lt' => date('G') * 60 + date('i'))
			));
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

<?php

interface IParser {
	public function getSiteCode();
	public function getSiteName();
	public function getParserName();
	public function getUrl();

	public function processJobList();
	public function processJob($id, $url);
}

class Parser {

	const Agent = 'workbreeze crawler';
	
	private $db;

	private $queue;
	private $jobs;
	
	private $queuedCount = 0;

	public function __construct($db) {
		$this->db = $db;
		
		$this->queue = $db->queue;
		$this->jobs  = $db->jobs;
	}
	
	protected function log($info) {
		$tmp = $this->db->log->findOne($info);
		
		if (null === $tmp) {
			$info['stamp'] = time();
			$this->db->log->insert($info);
		}
	}
	
	protected function checkCategories($cats) {
		$cmap = $this->db->cats_map;
		
		$rcats = array();
		
		foreach($cats as $key => $cat) {
			$tmp = $cmap->findOne(array(
				'site' => $this->getSiteCode(),
				'id'   => $key
			));
			
			if (null != $tmp) {
				$rcats[] = $tmp['map'];
			} else {
				$this->log(array(
					'site' => $this->getSiteCode(),
					'msg'  => 'category is not mapped',
					'cat'  => $key . ' -> ' . $cat
				));
			}
		}

		return $rcats;
	}
	
	protected function queueJobLink($jobId, $link) {
		$info = array(
			'site' => $this->getSiteCode(),
			'id'   => $jobId
		);
	
		$tmp = $this->jobs->findOne($info);
		
		if (null != $tmp)
			return false;
			
		$info['type'] = 'job';
			
		$tmp = $this->queue->findOne($info);
		
		if (null != $tmp)
			return false;
			
		echo 'Queueing job [' . $link . "]\n";
		
		$info['url'] = $link;
		
		$this->queue->insert($info);
		
		$this->queuedCount++;
		
		return true;
	}
	
	protected function addJob($info) {
		$info['site']  = $this->getSiteCode();
		$info['stamp'] = time();
		
		if (
			isset($info['categories'])
			&& 0 === count($info['categories'])
		) {
			unset($info['categories']);
		}
	
		$this->db->jobs->insert($info);
		
		echo 'Job ' . $info['id'] . " added\n";

		return true;
	}
	
	protected function afterRequest($data) {
		return $data;
	}

	protected function getRequest($url) {
		$c = curl_init();
		
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_USERAGENT, Parser::Agent);
		curl_setopt($c, CURLOPT_ENCODING, 'gzip');
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($c);
		curl_close($c);
	
		$result = $this->afterRequest($result);
		
		return $result;
	}

}

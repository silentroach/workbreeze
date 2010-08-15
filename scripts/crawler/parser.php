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
	
	protected function log($url, $message, $page) {
		$info = array(
			'url' => $url,
			'message' => $message,
			'page' => $page
		);
		
		$this->db->log->insert($info);
	}
	
	protected function checkCategories($cats) {
		return array();
	}
	
	protected function queueJobLink($jobId, $link) {
		$info = array(
			'site' => $this->getSiteCode(),
			'type' => 'job',
			'id'   => $jobId
		);
	
		$tmp = $this->jobs->findOne($info);
		
		if (null != $tmp)
			return false;
			
		$tmp = $this->queue->findOne($info);
		
		if (null != $tmp)
			return false;
			
		echo 'Queueing job [' . $link . "]\n";
		
		$info['url'] = $link;
		
		$this->queue->insert($info);
		
		$this->queuedCount++;
		
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

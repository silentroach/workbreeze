<?php

interface IParser {
	public function getSiteCode();
	public function getSiteName();
	public function getSiteFolder();
	public function getParserName();
	public function getUrl();
	public function getLang();
	public function isProxyfied();

	public function processJobList();

	public function getUpdatePeriod();
	
	public function parseJobTitle($content);
	public function parseJobDescription($content);
	public function parseJobCategories($content);
	public function parseJobMoney($content);
}

class Parser {

	const Agent = 'Mozilla/5.0 (compatible; WorkbreezeCrawler/1.0; +http://workbreeze.com)';
	
	private $db;

	private $queue;
	private $jobs;
	
	private $queuedCount = 0;

	public function __construct($db) {
		$this->db = $db;
		
		$this->queue = $db->queue;
		$this->jobs  = $db->jobs;
	}
	
	public function getQueuedCount() {
		return $this->queuedCount;
	}
	
	public function processJob($id, $url) {
		$content = $this->getRequest($url);
		
		if (
			!$content
			|| 404 == $content
		) {
			return true;
		}
		
		$job = $this->newJob();
		
		$job->setId($id);
		$job->setUrl($url);
		
		$title = $this->parseJobTitle($content);
		if (!$title) {
			$this->log(array(
				'url' => $url,
				'info' => 'can\'t parse title'
			));
		
			return true;
		}
			
		$job->setTitle($title);
		
		$desc = $this->parseJobDescription($content);
		if (!$desc) {
			$this->log(array(
				'url' => $url,
				'info' => 'can\'t parse description'
			));
		
			return true;
		}
			
		$job->setDescription($desc);
		
		$cats = $this->parseJobCategories($content);
		if (false !== $cats)
			$job->setCategoriesByText($cats);
			
		$money = $this->parseJobMoney($content);
		if (false !== $money)
			$job->setMoney($money);
			
		return $this->addJob($job);
	}
	
	protected function log($info) {
		$info['stamp'] = time();
		$this->db->log->insert($info);
		
		if (isset($info['msg'])) {
			echo '[' . date('H:m:s') . '] ' . $info['msg'] . "\n";
		}
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
			
		echo '[' . date('H:m:s') . '] Queueing job [' . $link . "]\n";
		
		$info['url'] = $link;
		$info['rnd'] = rand(1, 10000);
		
		$this->queue->insert($info);
		
		$this->queuedCount++;
		
		return true;
	}
	
	private function getJobPagePath($id) {
		return PATH_PUBLIC . 'jobs' 
			. DIRECTORY_SEPARATOR . $this->getSiteFolder() 
			. DIRECTORY_SEPARATOR . $id . '.html';
	}
	
	private function generateJobPage($job) {
		$fname = $this->getJobPagePath($job->getId());
		
		if (!file_exists(dirname($fname))) {
			mkdir(dirname($fname), 0777, true);
		}
		
		$title = $job->getTitle();
		
		$money = $job->getMoney();
		
		if (count($money)) {
			switch ($money[1]) {
				case Job::CUR_DOLLAR:
					$currency = '$%d';
					break;
				case Job::CUR_EURO;
					$currency = '&euro;%d';
					break;
				case Job::CUR_RUBLE:
					$currency = '%d руб.';
					break;
			}
			
			if (isset($currency)) {
				$title .= ' [ ' . sprintf($currency, $money[0]) . ' ]';
			}
		}

		switch ($this->getLang()) {
			case Language::RUSSIAN:
				$cl = 'ru';
				break;
			case Language::ENGLISH:
				$cl = 'en';
				break;
			default:
				$cl = 'ru,en';
				break;
		}
		
		$pageContent = <<<EOF
<p class="title">{$title}</p>

{$job->getHTMLDescription()}
<br /><br />

<a href="{$job->getUrl()}" class="sico sico_{$this->getSiteCode()}">{$this->getSiteName()}</a>
EOF;
		
		$page = new Page();
		$page->setTitle($title);
		$page->setDescription($job->getTitle() . ', ' . $this->getSiteName());
		$page->setLang($cl);
		$page->setContent($pageContent);

		$page->save($fname);
	}
	
	protected function addJob($job) {
		if ($job->insert()) {		
			$this->generateJobPage($job);
			echo '[' . date('H:m:s') . '] Job ' . $job->getId() . " added\n";
			
			return true;
		}

		return false;
	}
	
	protected function newJob() {
		return Job::createBySite($this->db, $this->getSiteCode());
	}
	
	protected function afterRequest($data) {
		return $data;
	}
	
	public function publicAfterRequest($data) {
		return $this->afterRequest($data);
	}

	protected function getRequest($url, $headers = array()) {
		$c = curl_init();
		
		echo '[' . date('H:m:s') . '] ' . $url . '... ';
		
		$url = str_replace(' ', '%20', $url);
		
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_USERAGENT, Parser::Agent);
		curl_setopt($c, CURLOPT_ENCODING, 'gzip');
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		
		if (0 !== sizeof($headers)) {
			curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
		}
		
		if (
			$this->isProxyfied()
			&& file_exists('/var/run/tor')
		) {
			curl_setopt($c, CURLOPT_HTTPPROXYTUNNEL, true);
			curl_setopt($c, CURLOPT_PROXY, 'localhost');
			curl_setopt($c, CURLOPT_PROXYPORT, 9050);
			curl_setopt($c, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
		}
		
		$result = curl_exec($c);
			
		$info = curl_getinfo($c);
		
		curl_close($c);
		
		if (
			isset($info['size_download'])
		) {
			$bytes = (int) $info['size_download'];
			$symbol = array('b', 'kb', 'mb');

			$exp = 0;
			$converted_value = 0;
			if ($bytes > 0) {
				$exp = floor( log($bytes)/log(1024) );
				$converted_value = ( $bytes/pow(1024,floor($exp)) );
			}

			echo '[' . sprintf( '%.2f '.$symbol[$exp], $converted_value ) . "]\n";
		}
		
		if (
			isset($info['http_code'])
			&& 200 != $info['http_code']
		) {
			if (404 == $info['http_code']) {
				return 404;
			} else		
				return false; 
		}
	
		$result = $this->afterRequest($result);
		
		return $result;
	}

}

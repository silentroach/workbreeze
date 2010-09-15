<?php

require(PATH_CLASSES . 'job.php');
require_once(PATH_CLASSES . 'language.php');

interface IParser {
	public function getSiteCode();
	public function getSiteName();
	public function getSiteFolder();
	public function getParserName();
	public function getUrl();
	public function getLang();
	public function isProxyfied();

	public function processJobList();
	
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
		$tmp = $this->db->log->findOne($info);
		
		if (null === $tmp) {
			$info['stamp'] = time();
			$this->db->log->insert($info);
		}
		
		if (isset($info['msg']))
			echo $info['msg'] . "\n";
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
	
		$ga = file_get_contents(PATH_OTHER . 'ga.js');
		
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
	
		$content = <<<EOF
<!DOCTYPE html>
<html>
        <title>WorkBreeze - {$title}</title>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" href="/css/main.css" type="text/css" />
<body>

<div id="gads">
<script type="text/javascript">google_ad_client = "pub-0168627540498115";google_ad_slot = "1958922984";google_ad_width = 120;google_ad_height = 240;</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>

<div id="logo"><a href="/">WorkBreeze</a></div>

<p class="title">{$title}</p>

{$job->getHTMLDescription()}
<br /><br />

<a href="{$job->getUrl()}" class="sico sico_{$this->getSiteCode()}">{$this->getSiteName()}</a>

{$ga}
</body>
</html>
EOF;

		$content = str_replace(array("\t", "\r", "\n"), '', $content);
		
		while (false !== strpos($content, '  ')) {
			$content = str_replace('  ', ' ', $content);
		}
		
		file_put_contents($fname, $content);
		
		$out = system('gzip -c9 ' . $fname . ' > ' . $fname . '.gz');
	}
	
	protected function addJob($job) {
		if ($job->insert()) {		
			$this->generateJobPage($job);
			echo 'Job ' . $job->getId() . " added\n";
			
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

	protected function getRequest($url) {
		$c = curl_init();
		
		echo $url . '... ';
		
		$url = str_replace(' ', '%20', $url);
		
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_USERAGENT, Parser::Agent);
		curl_setopt($c, CURLOPT_ENCODING, 'gzip');
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		
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

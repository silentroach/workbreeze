<?php

/**
 * Interface for all the parsers
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
interface IParser {
	// site code (identifier in the database)
	public function getSiteCode();
	// site name
	public function getSiteName();
	// folder to store site jobs
	public function getSiteFolder();
	// the name of parser
	public function getParserName();
	// site url
	public function getUrl();
	// job language
	public function getLang();

	// use proxy to get info
	public function isProxyfied();
	// use authorisation (credentials.php)
	public function isAuth();

	// function to get job list to queue
	public function processJobList();

	// period to check new jobs
	public function getUpdatePeriod();

	// extract title from page
	public function parseJobTitle($content);
	// extract description from page
	public function parseJobDescription($content);
	// extract categories (textual) from page
	public function parseJobCategories($content);
	// extract budget from page
	public function parseJobMoney($content);
}

/**
 * Base parser class
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 */
class Parser {

	const Agent     = 'Mozilla/5.0 (compatible; WorkbreezeCrawler/1.0; +http://workbreeze.com)';
	const UserAgent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.7 (KHTML, like Gecko) Chrome/7.0.517.41 Safari/534.7';
	
	private $queuedCount = 0;

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

		// replace local links with real links to parser site
		$desc = str_replace('href="/', 'href="' . $this->getUrl() . '/', $desc);

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
		Database::log()->insert($info);
		
		if (isset($info['msg'])) {
			echo '[' . date('H:m:s') . '] ' . $info['msg'] . "\n";
		}
	}
	
	protected function queueJobLink($jobId, $link) {
		$info = array(
			'site' => $this->getSiteCode(),
			'id'   => $jobId
		);
	
		$tmp = Database::jobs()->findOne($info);
		
		if (null != $tmp)
			return false;
			
		$info['type'] = 'job';
			
		$tmp = Database::queue()->findOne($info);
		
		if (null != $tmp)
			return false;
			
		echo '[' . date('H:m:s') . '] Queueing job [' . $link . "]\n";
		
		$info['url'] = $link;
		$info['rnd'] = rand(1, 10000);
		
		Database::queue()->insert($info);
		
		$this->queuedCount++;
		
		return true;
	}
	
	private function getJobPagePath($id) {
		return PATH_PUBLIC . 'jobs' . DS . $this->getSiteFolder() . DS . $id;
	}
	
	protected function addJob($job) {
		if ($job->insert()) {		
			echo '[' . date('H:m:s') . '] Job ' . $job->getId() . " added\n";
			
			return true;
		}

		return false;
	}
	
	protected function newJob() {
		return Job::createBySite($this->getSiteCode());
	}
	
	protected function afterRequest($data) {
		return $data;
	}
	
	public function publicAfterRequest($data) {
		return $this->afterRequest($data);
	}

	protected function getRequest($url, $headers = array(), $post = array()) {
		$c = curl_init();
		
		echo '[' . date('H:m:s') . '] ' . $url . '... ';
		
		$url = str_replace(' ', '%20', $url);
		
		curl_setopt($c, CURLOPT_URL, $url);                 // url to get
		curl_setopt($c, CURLOPT_ENCODING, 'gzip');          // try to get into gzip
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);      // return output back into script
		curl_setopt($c, CURLOPT_TIMEOUT, 30);               // 30 seconds for timeout
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);      // not to check ssl certificates
		
		if (0 !== sizeof($headers)) {
			// setting headers
			curl_setopt($c, CURLOPT_HTTPHEADER, $headers);   
		}

		if (0 !== sizeof($post)) {
			// sending the post data
			curl_setopt($c, CURLOPT_POST, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		}

		if ($this->isAuth()) {
			// setting the real useragent
			curl_setopt($c, CURLOPT_USERAGENT, Parser::UserAgent);

			// setting the cookie storage
			curl_setopt($c, CURLOPT_COOKIEJAR,  '/tmp/authcookies');
			curl_setopt($c, CURLOPT_COOKIEFILE, '/tmp/authcookies');

			// follow the location if redirect is returned
			curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		} else {
			// setting the default crawler useragent
			curl_setopt($c, CURLOPT_USERAGENT, Parser::Agent);
		}

		if (
			$this->isProxyfied()
			&& file_exists('/var/run/tor')
		) {
			// try to work via tor proxy if it is needed
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

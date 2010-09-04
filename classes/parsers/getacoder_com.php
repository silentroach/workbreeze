<?php

class Parser_getacoder_com extends Parser implements IParser {

	public function getSiteCode() {
		return 4;
	}
	
	public function getSiteName() {
		return 'getacoder.com';
	}
	
	public function getSiteFolder() {
		return 'getacoder_com';
	}
	
	public function getParserName() {
		return 'GetACoder parser 0.1';
	}
	
	public function getUrl() {
		return 'http://www.getacoder.com';
	}
	
	public function isProxyFied() {
		return false;
	}
	
	public function processJobList() {
		$res = $this->getRequest('http://www.getacoder.com/');

		if (!$res)
			return false;

/*
<a href="http://www.getacoder.com/projects/traffic_script_program_132791.html" style="color: #113456" class="smaller">
	Traffic Script Program
</a>
*/

		preg_match_all('/<a href="http:\/\/www.getacoder.com\/projects\/(.*?)"/', $res, $matches);
		
		array_shift($matches);
			
		if (0 === count($matches))
			return;
			
		$matches = array_shift($matches);

		foreach($matches as $match) {
			$this->queueJobLink(md5($match), 'http://www.getacoder.com/projects/' . $match);
		}
	}
	
	public function processJob($id, $url) {
		$res = $this->getRequest($url);
		
		if (!$res)
			return false;
			
		if (404 === $res)
			// drop queued jobs that are not found
			return true;

/*
<b>Description</b></FONT> 
<hr color="#000000" size="1">	
	I am in need of a traffic generating script/program that will allow me to test all of my tracking
	software solutions. I need the script to be able to provide clicks, impressions, unique ip, and 
	different browsers.  
</span> 
*/
		if (
			!preg_match('/Description<\/b><\/FONT>(.*?)>(.*?)<\/span>/is', $res, $matches)
			|| 3 != count($matches)
		) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract description' 
			));
			return true;
		}
		
		$desc = $matches[2];
		
		if (
			!preg_match('/<title>(.*?)<\/title>/is', $res, $matches)
			|| 2 != count($matches)
		) {
			$this->log(array(
				'url' => $url,
				'msg' => 'can\'t extract description'
			));
			return true;
		}
		
		$title = $matches[1];
		
		if (
			!preg_match('/\((.*?)\)/is', $title, $matches)
			|| 2 != count($matches)
		) {
			$this->log(array(
				'url' => $url,
				'msg' => 'can\'t extract categories'			
			));
			return true;
		}
		
		$title = trim(str_replace($matches[0], '', $title));
		$cats = $matches[1];		
		
		$job = $this->newJob();
		$job->
			setId($id)->
			setUrl($url)->
			setTitle($title)->
			setDescription($desc);
		
		if ('' !== $cats) {
			$job->setCategoriesByText($cats);
		}
				
		$this->addJob($job);

		return true;
	}
	
}




















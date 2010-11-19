<?php

/**
 * odesk.com parser
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 */
class Parser_odesk_com extends Parser implements IParser {

	public function getSiteCode() {
		return 7;
	}
	
	public function getSiteName() {
		return 'odesk.com';
	}
	
	public function getSiteFolder() {
		return 'odesk_com';
	}
	
	public function getParserName() {
		return 'ODesk parser 1.0';
	}
	
	public function getUrl() {
		return 'http://www.odesk.com';
	}

	public function getUpdatePeriod() {
		return 60 * 3;   // 3 minutes
	}

	public function getLang() {
		return Language::ENGLISH;
	}
	
	public function isProxyfied() {
		return false;
	}

	public function isAuth() {
		return false;
	}
	
	public function processJobList() {
		$res = $this->getRequest(
			'http://www.odesk.com/jobs/?st=0&format=json',
			array(
				'X-Requested-With: XMLHttpRequest'
			)
		);

		if (!$res)
			return false;
	
		$items = json_decode($res);
		
		if (!property_exists($items, 'content')) {
			return;
		}
		
		$res = $items->content;
				
/*
<a name="job_1" href="/jobs/Seeking-Press-Release-writer-and-distributor_%7E%7Ed50137ed9a1e167d?tot=5000&amp;pos=0" alt="Seeking a Press Release writer and distributor">
	Seeking a Press Release writer and distributor
</a>
*/

		preg_match_all('/<a name="job_(\d+)" href="(\/jobs\/(.*?))"/siu', $res, $matches);
		
		if (4 != count($matches))
			return;
		
		$urls = $matches[2];

		foreach($urls as $match) {
			$i = strpos($match, '?');
			
			if (false !== $i) {
				$match = substr($match, 0, $i);
			}
		
			$this->queueJobLink(md5($match), 'http://www.odesk.com' . $match);
		}
	}
	
	public function parseJobTitle($content) {
		if (
			!preg_match('/jobTitleBar">(.*?)<h1>(.*?)<\/h1>/siu', $content, $matches)
			|| 3 != count($matches)
		) {
			return false;
		}

		return $matches[2];
	}
	
	public function parseJobDescription($content) {
		if (
			!preg_match('/<p id="jobDescription">(.*?)<\/p>/siu', $content, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}
		
		$desc = $matches[1];
		
		// odesk.com out script
		if (preg_match_all('/<a href=(.*?)\/leaving_odesk.php\?ref=(.*?)"(.*?)>(.*?)<\/a>/sui', $desc, $matches)) {
			$targets = array_shift($matches);
			
			// offset before leaving_odesk.php
			array_shift($matches);
			
			$urls = array_shift($matches);
			
			array_shift($matches);
			
			$inner = array_shift($matches);
			
			foreach($urls as $key => $url) {
				$urlnew = urldecode($url);

				$desc = str_replace($targets[$key], '<a href="' . $urlnew . '">' . $inner[$key] . '</a>', $desc);
			}
		}
		
		return $desc;
	}
	
	public function parseJobCategories($content) {
		$cats = '';
	
		if (
			preg_match_all('/<a href="\/jobs\/\?c1=(.*?)>(.*?)<\/a>/siu', $content, $matches)
			&& 3 == count($matches)
		) {
			$cats .= implode(' ', array_pop($matches));
		}
		
		// skills
		if (
			(
				preg_match_all('/<a href="\/jobs\/\?qs=(.*?)>(.*?)<\/a>/siu', $content, $matches)
				|| preg_match_all('/<a href="\/jobs\/skill\/(.*?)>(.*?)<\/a>/siu', $content, $matches)
			) && 3 === sizeof($matches)
		) {	
			$cats .= ' ' . implode(' ', array_pop($matches));
		}
		
		return ('' !== $cats) ? $cats : false;
	}
	
	public function parseJobMoney($content) {
		// @todo parse money
			
		return false;
	}
		
}

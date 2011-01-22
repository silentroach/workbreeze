<?php

/**
 * scriptlance.com parser
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class Parser_scriptlance_com extends Parser implements IParser {

	public function getSiteCode() {
		return 6;
	}
	
	public function getSiteName() {
		return 'scriptlance.com';
	}
	
	public function getSiteFolder() {
		return 'scriptlance_com';
	}
	
	public function getParserName() {
		return 'Scriptlance parser 1.0';
	}
	
	public function getUrl() {
		return 'http://www.scriptlance.com';
	}
	
	public function getUpdatePeriod() {
		return 60 * 2; // 2 minutes
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
	
	protected function afterRequest($data) {
		return iconv('iso-8859-1', 'utf-8', $data);
	}	
	
	public function processJobList() {
		$res = $this->getRequest('http://www.scriptlance.com/programmers/projects.shtml');

		if (!$res)
			return false;

/*
http://www.scriptlance.com/projects/1284565862.shtml
*/

		preg_match_all('/http:\/\/www.scriptlance.com\/projects\/(\d+).shtml/', $res, $matches);
		
		if (2 != count($matches))
			return;
		
		$matches = array_combine($matches[1], $matches[0]);

		foreach($matches as $id => $match) {
			if (!preg_match('@><a href="' . $match . '(.*?)</tr>@siu', $res, $matches)) {
				continue;
			}	
			
			$tmp = array_pop($matches);
			
			if (false !== strpos($tmp, 'private.gif')) {
				// skipping private projects
				continue;
			}
			
			$this->queueJobLink($id, $match);
		}
	}
	
	public function parseJobTitle($content) {
		if (
			!preg_match('/<big>(.*?)<\/big>/iu', $content, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}
				
		return trim($matches[1]);
	}
	
	public function parseJobDescription($content) {
		if (
			!preg_match('/Description:<\/td>(.*?)<\/td>/siu', $content, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}

		return str_replace(array("\r", "\n"), '', $matches[1]);
	}
	
	public function parseJobCategories($content) {
		if (
			!preg_match('/Tags:<\/td>(.*?)<table(.*?)<\/table>/siu', $content, $matches)
			|| 3 != count($matches)
		) {
			return false;
		}
		
		$tags = array_pop($matches);
		
		if (
			!preg_match_all('/<a (.*?)>(.*?)<\/a>/siu', $tags, $matches)
			|| 3 != count($matches)
		) {
			return false;
		}
		
		$tags = array_pop($matches);
		
		if (count($tags)) {
			array_pop($tags);
		}
		
		return trim(implode(', ', $tags));
	}
	
	public function parseJobMoney($content) {
		if (
			!preg_match('/Budget:<\/td>(.*?)top>(.*?)<\/td>/siu', $content, $matches)
			|| 3 != count($matches)
		) {
			return false;
		}
		
		$val = trim(array_pop($matches));
			
		if (false !== mb_strpos($val, '$')) {
			$currency = Job::CUR_DOLLAR;
			$val = str_replace('$', '', $val);
		}
		
		if (!isset($currency)) {
			return false;
		}
		
		$vals = explode('-', $val);
		
		if (count($vals) == 0) {
			return false;
		}
		
		$val = array_pop($vals);
					
		$val = floatval(trim($val));
		
		if (
			isset($currency)
			&& $val != 0
		) {
			return array(
				$val,
				$currency
			);
		}
		
		return false;
	}
		
}

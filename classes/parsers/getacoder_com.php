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
		return 'GetACoder parser 1.0';
	}
	
	public function getUrl() {
		return 'http://www.getacoder.com';
	}
	
	public function getLang() {
		return Language::ENGLISH;
	}
	
	public function isProxyFied() {
		return false;
	}
	
	protected function afterRequest($data) {
		return iconv('iso-8859-1', 'utf-8', $data);
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
	
	public function parseJobTitle($content) {
		if (
			!preg_match('/<title>(.*?)</siu', $content, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}
		
		$title = $matches[1];
		
		$m = explode('(', $title);
		
		if (count($m) == 0)
			return false;
			
		$title = array_shift($m);
		
		return trim($title);
	}
	
	public function parseJobDescription($content) {
		if (
			!preg_match('/Description<\/b><\/FONT>(.*?)>(.*?)<\/span>/siu', $content, $matches)
			|| 3 != count($matches)
		) {
			return false;
		}
		
		$desc = $matches[2];
		
		$i = mb_strpos($desc, '<b>Additional information:</b>');
		if (false !== $i) {
			$desc = mb_substr($desc, 0, $i);
		}
		
		return $desc;
	}
	
	public function parseJobCategories($content) {
		if (
			!preg_match('/<title>(.*?)<\/title>/siu', $content, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}
		
		$title = $matches[1];
		
		$m = explode('(', $title);
		
		if (count($m) == 0) {
			return false;
		}
		
		array_shift($m);
		
		$tags = array_shift($m);
		
		return str_replace(array('(', ')'), ' ', $tags);	
	}
	
	public function parseJobMoney($content) {
		if (
			preg_match('/Budget:<\/b>(.*?)<small>(.*?)<\/small>/siu', $content, $matches)
			&& 3 == count($matches)
		) {
			$val = str_replace('&nbsp;', ' ', array_pop($matches));

			if (false !== mb_strpos($val, '$')) {
				$currency = Job::CUR_DOLLAR;
				
				$val = trim(preg_replace('/\$/siu', '', $val));
				
				$vals = explode('-', $val);
				
				$val = floatval(array_pop($vals));
			}
			
			if (
				isset($currency)
				&& $val != 0
			) {
				return array(
					$val,
					$currency
				);
			}
		}
	}
		
}

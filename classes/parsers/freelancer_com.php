<?php

class Parser_freelancer_com extends Parser implements IParser {

	public function getSiteCode() {
		return 3;
	}
	
	public function getSiteName() {
		return 'freelancer.com';
	}
	
	public function getSiteFolder() {
		return 'freelancer_com';
	}
	
	public function getParserName() {
		return 'Freelancer parser 1.0';
	}
	
	public function getUrl() {
		return 'http://www.freelancer.com';
	}

	public function getUpdatePeriod() {
		return 60; // 1 minute
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
		$res = $this->getRequest('http://www.freelancer.com/projects/all.php');

		if (!$res)
			return false;

/*
<a href="../projects/Graphic-Design-Logo-Design/logo-design-needed-Sulais.html" class="">A logo design needed #6 (Sulais)</a>
*/

		preg_match_all('/<a href="..\/projects\/(.*?)"/', $res, $matches);
		
		array_shift($matches);
			
		if (0 === count($matches))
			return;
			
		$matches = array_shift($matches);

		foreach($matches as $match) {
			if (!preg_match('/^(\d+).html/', $match, $matches)) {
				$this->queueJobLink(md5($match), "http://www.freelancer.com/projects/" . $match);
			}
		}
	}
	
	public function parseJobTitle($content) {
		if (
			!preg_match('/<h2(.*?)>(.*?)<\/h2>/is', $content, $matches)
			|| 3 != count($matches)
		) {
			return false;
		}
		
		$title = array_pop($matches);
		
		$title = strip_tags($title);
		
		return str_replace('&nbsp;', '', $title);
	}
	
	public function parseJobDescription($content) {
		$i = mb_strpos($content, '<h3>Description</h3>');
		if (false === $i) {
			return false;
		}
		
		$desc = mb_substr($content, $i, mb_strlen($content) - $i);

		$i = mb_strpos($desc, '<td');
		if (false === $i) {
			return false;
		}
		
		$desc = mb_substr($desc, $i + 3, mb_strlen($desc) - $i - 3);

		$i = mb_strpos($desc, '>');
		if (false === $i) {
			return false;
		}

		$desc = mb_substr($desc, $i + 1, mb_strlen($desc) - $i - 1);
		
		$i = mb_strpos($desc, '</td>');
		if (false === $i) {
			return false;
		}
		
		return mb_substr($desc, 0, $i);
	}
	
	public function parseJobCategories($content) {
		$cats = '';
		
		if (
			preg_match_all('/projects\/by-job\/(.*?)>(.*?)</siu', $content, $matches)
			&& 3 == count($matches)
		) {
			$cc = array_pop($matches);
		
			return implode(' ', $cc);
		}

		return false;
	}
	
	public function parseJobMoney($content) {
		if (
			preg_match('/Budget: <\/strong>(.*?)<\/p>/siu', $content, $matches)
			&& 2 == count($matches)
		) {
			$val = array_pop($matches);

			$val = str_replace('&#36;', '$', $val);
			
			if (
				false !== mb_strpos($val, '$')
				|| false !== mb_strpos($val, 'USD')
			) {
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
		
		return false;
	}
		
}

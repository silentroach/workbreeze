<?php

class Parser_freelance_ru extends Parser implements IParser {

	public function getSiteCode() {
		return 1;
	}
	
	public function getSiteName() {
		return 'free-lance.ru';
	}
	
	public function getSiteFolder() {
		return 'freelance_ru';
	}

	public function getParserName() {
		return 'Free-Lance.ru parser 1.0';
	}
	
	public function getUrl() {
		return 'http://www.free-lance.ru';
	}

	public function getUpdatePeriod() {
		return 60;  // 1 minute
	}

	public function getLang() {
		return Language::RUSSIAN;
	}
	
	public function isProxyfied() {
		return true;
	}

	protected function afterRequest($data) {
		return iconv('cp1251', 'utf-8', $data);
	}
	
	public function parseJobTitle($content) {
		if (
			preg_match('/<h3>(.*?)<\/h3>/', $content, $matches)
			&& 2 === count($matches)
		) {
			return trim($matches[1]);
		} else
		if (preg_match('/<h2 class="prj_name">(.*?)<\/h2>/', $content, $matches)) {
			return trim($matches[1]);
		}
		
		return false;
	}
	
	public function parseJobDescription($content) {
		$contest = false;

		if (
			preg_match('/<h3>(.*?)<\/h3>/', $content, $matches)
			&& 2 === count($matches)
		) {			
			$contest = true;
		} else
		if (!preg_match('/<h2 class="prj_name">(.*?)<\/h2>/', $content, $matches)) {
			return false;
		}
		
		if (!$contest) {
			preg_match('/prj_text"(.*?)>(.*?)<\/div>/is', $content, $matches);
			
			if (3 != count($matches)) {
				return false;
			}
		
			array_shift($matches);
			array_shift($matches);
		
			$desc = array_shift($matches);
		} else {
			preg_match('/<\/h3>(.*?)<\/div/is', $content, $matches);
			
			if (2 != count($matches)) {
				return false;
			}
					
			$desc = $matches[1];
		}	
		
		// free-lance.ru out script
		if (preg_match_all('/<a href=(.*?)\/a.php\?href=(.*?)"(.*?)>(.*?)<\/a>/sui', $desc, $matches)) {
			$targets = array_shift($matches);
			
			// offset before a.php
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
		$k = mb_strlen('Раздел:');
		$i = mb_strpos($content, 'Раздел:');
		
		if (false !== $i) {
			$n = mb_strpos($content, '</div>', $i);
			
			if (false !== $n) {
				return mb_substr($content, $i + $k, $n - $i - $k);
			}
		}	
		
		return false;
	}
	
	public function parseJobMoney($content) {
		if (
			preg_match('/Бюджет: (.*?)&nbsp;(.*?)</siu', $content, $matches)
			&& 3 == count($matches)
		) {
			array_shift($matches);

			if ('Р.' === $matches[1]) {
				$currency = Job::CUR_RUBLE;
				$val = $matches[0];
			} else
			if ('$' === $matches[0]) {
				$currency = Job::CUR_DOLLAR;
				$val = $matches[1];
			} else {
				return false;
			}

			return array(
				$val,
				$currency
			);
		}
		
		return false;
	}

	public function processJobList() {
		$res = $this->getRequest('http://www.free-lance.ru/?kind=5');
		
		if (!$res)
			return false;
			
/*
	<a class="prjlnk" name="prj468407" href="/projects/?pid=468407">
*/

		preg_match_all('/href="(\/projects\/\?pid=(\d+))"/', $res, $matches);
		
		array_shift($matches);
	
		if (0 === count($matches))
			return;
			
		$matches = array_combine($matches[1], $matches[0]);

		foreach($matches as $key => $match) {
				$this->queueJobLink($key, 'http://www.free-lance.ru' . $match);
		}
	}
	
}

<?php

class Parser_freelancejob_ru extends Parser implements IParser {

	public function getSiteCode() {
		return 2;
	}
	
	public function getSiteName() {
		return 'freelancejob.ru';
	}
	
	public function getSiteFolder() {
		return 'freelancejob_ru';
	}
	
	public function getParserName() {
		return 'Freelance Job parser 1.0';
	}
	
	public function getUrl() {
		return 'http://freelancejob.ru';
	}
	
	public function getLang() {
		return Language::RUSSIAN;
	}

	public function getUpdatePeriod() {
		return 60 * 10;  // 10 minutes for update
	}
	
	public function isProxyfied() {
		return false;
	}

	public function isAuth() {
		return false;
	}

	protected function afterRequest($data) {
		return iconv('cp1251', 'utf-8', $data);
	}
	
	public function parseJobTitle($content) {
		if (
			!preg_match('/<h1>(.*?)<\/h1>/', $content, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}

		return $matches[1];
	}
	
	public function parseJobDescription($content) {
		if (
			!preg_match('/<h1>(.*?)<\/h1>/', $content, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}
		
		$i = mb_strpos($content, $matches[0]);
		if (false === $i) {
			// something is impossible wrong O.o
			return false;
		}
		
		$desc = mb_substr($content, $i, mb_strlen($content) - $i);
		
		$i = mb_strpos($desc, '</table>');
		if (false === $i) {
			return false;
		}
		
		$desc = mb_substr($desc, 0, $i);
		
		if (
			!preg_match('/<td>(.*?)<\/td>/is', $desc, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}

		$desc = $matches[1];
		$i = mb_strpos($desc, '<br/><br/><br/>');
		
		if (false === $i) {
			return false;
		}
		
		$desc = mb_substr($desc, 1, $i - 1);
		
		$desc = str_replace(array("\r", "\n"), '', $desc);

		return $desc;	
	}
	
	public function parseJobCategories($content) {
		if (
			preg_match('/<b>Категория:<\/b>(.*?)<br\/><br\/>/ius', $content, $matches)
			&& 2 == count($matches)
		) {
			return $matches[1];
		}
		
		return false;
	}
	
	public function parseJobMoney($content) {
		if (
			preg_match('/<b>Бюджет:<\/b> (.*?) (.*?)<br\/>/ius', $content, $matches)
			&& 3 == count($matches)
		) {
			$count = $matches[1];
			$cur = $matches[2];
			
			switch ($cur) {
				case 'руб.':
					$currency = Job::CUR_RUBLE;
					break;
			}
			
			if (isset($currency)) {
				return array(
					$count,
					$currency
				);
			}
		}
		
		return false;
	}
	
	public function processJobList() {
		$res = $this->getRequest('http://freelancejob.ru/');

		if (!$res)
			return false;
				
/*
<a href="/vacancy/9107/" class="big">Дизайн дорого</a>
*/

		preg_match_all('/href="(\/vacancy\/(\d+))\/"/', $res, $matches);
		
		array_shift($matches);
	
		if (0 === count($matches))
			return;
			
		$matches = array_combine($matches[1], $matches[0]);

		foreach($matches as $key => $match) {
				$this->queueJobLink($key, 'http://www.freelancejob.ru' . $match);
		}
	}
	
}

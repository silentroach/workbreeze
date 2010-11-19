<?php

/**
 * weblancer.net parser
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 */
class Parser_weblancer_net extends Parser implements IParser {

	public function getSiteCode() {
		return 0;
	}
	
	public function getSiteName() {
		return 'weblancer.net';
	}

	public function getParserName() {
		return 'WebLancer parser 1.0';
	}
	
	public function getSiteFolder() {
		return 'weblancer_net';
	}
	
	public function getUrl() {
		return 'http://www.weblancer.net';
	}

	public function getUpdatePeriod() {
		return 60 * 3; // 3 minutes
	}
	
	public function getLang() {
		return Language::RUSSIAN;
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
			preg_match('/<div class=\"title_box\">(.*?)<h1>(.*?)<\/h1>/', $content, $matches)
			&& 3 == count($matches)
		) {
			return trim($matches[2]);
		}
		
		return false;
	}
	
	public function parseJobDescription($content) {
		if (
			preg_match('/id_description">(.*?)<a name="bid/siu', $content, $matches)
			&& 2 == count($matches)
		) {		
			array_shift($matches);
		
			$desc = array_shift($matches);
		
			$i = mb_strpos($desc, '[Приложения]');
		
			if (false !== $i) {
				$desc = mb_substr($desc, 0, $i);
			}
		
			$desc = preg_replace('/<div class="disabled">(.*?)<\/div>/siu', '', $desc);
			$desc = preg_replace('/<span class="disabled">(.*?)<\/span>/siu', '', $desc);
			
			return str_replace(array("\n", "\r"), '', $desc);
		}
		
		return false;
	}
	
	public function parseJobCategories($content) {
		$cats = '';

		if (
			preg_match_all('/<a href="\/projects\/\?category_id=(\d+)">(.*?)</si', $content, $matches)
			&& 3 == count($matches)
		) {
			array_shift($matches);
			array_shift($matches);
			
			$cc = array_shift($matches);
			
			foreach($cc as $k) {
				$cats .= $k;
			}
		}
		
		if ('' != $cats) {
			return $cats;
		} else {
			return false;
		}
	}
	
	public function parseJobMoney($content) {
		if (
			preg_match('/title">Бюджет(.*?)"amount"(.*?)>(.*?)<\/b>/siu', $content, $matches)
			&& 4 == count($matches)
		) {
			$val = $matches[3];
			
			$val = trim(preg_replace('/до/siu', '', $val));
			
			if (mb_strpos($val, 'USD')) {
				$currency = Job::CUR_DOLLAR;
				$val = trim(preg_replace('/USD/', '', $val));
			}
			
			if (
				isset($currency)
				&& $val != '0'
			) {
				return array(
					$val,
					$currency
				);
			}
		}
		
		return false;
	}
	
	public function processJobList() {
		$res = $this->getRequest('http://www.weblancer.net/projects/');

		if (!$res)
			return false;
	
		preg_match_all('/<a href=\"(\/projects\/(\d+).html)\"/', $res, $matches);
		
		array_shift($matches);
		
		if (0 === count($matches))
			return;

		for ($i = 0; $i < count($matches[0]); $i++ ) {
			$this->queueJobLink($matches[1][$i], 'http://www.weblancer.net' . $matches[0][$i]);
		}
	}
	
}


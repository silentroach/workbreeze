<?php

/**
 * freelance.ru parser
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class Parser_freelance_ru extends Parser implements IParser {

	public function getSiteCode() {
		return 8;
	}

	public function getSiteName() {
		return 'freelance.ru';
	}
	
	public function getSiteFolder() {
		return 'freelance_ru';
	}

	public function getParserName() {
		return 'FreeLance.ru parser 1.0';
	}
	
	public function getUrl() {
		return 'http://www.freelance.ru';
	}

	public function getUpdatePeriod() {
		return 60 * 5;  // 5 minute
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

	public function processJobList() {
		$res = $this->getRequest('http://freelance.ru/projects/');

		if (!$res) {
			return false;
		}

		if (
			preg_match_all('@proj public(.*?)href="/projects/(\d+)/"@siu', $res, $matches)
			&& 3 === sizeof($matches)
		) {
			$ids = array_pop($matches);

			foreach($ids as $id) {
				$this->queueJobLink($id, 'http://freelance.ru/projects/' . $id . '/');
			}
		}
	}

	public function parseJobTitle($content) {
		if (
			preg_match('@h2(.*?)proj_title(.*?)>(.*?)</h2>@siu', $content, $match)
			&& 4 === sizeof($match)
		) {
			return trim(array_pop($match));
		}

		return false;
	}

	public function parseJobDescription($content) {
		if (
			preg_match('@Описание проекта:(.*?)<p(.*?)txt(.*?)>(.*?)</p>@siu', $content, $match)
			&& 5 === sizeof($match)
		) {
			return trim(array_pop($match));
		}

		return false;
	}

	public function parseJobCategories($content) {
		$cats = array();

		if (
			preg_match('@Специализация:(.*?)<td class@siu', $content, $match)
			&& 2 === sizeof($match)
		) {
			$block = array_pop($match);

			if (
				preg_match_all('@<td>(.*?)</td>@siu', $block, $match)
				&& 2 === sizeof($match)
			) {
				$items = array_pop($match);

				foreach($items as $item) {
					$tmp = trim(strip_tags($item));

					if (!in_array($tmp, array('', '&nbsp;'))) {
						$cats[] = $tmp;
					}
				}
			}
			}

		return sizeof($cats) > 0 ? implode($cats, ' ') : false;
	}

	public function parseJobMoney($content) {
		if (
			preg_match('@Стоимость:(.*?)<td>(.*?)</td>@siu', $content, $match)
			&& 3 === sizeof($match)
		) {
			$tmp = explode(' ', array_pop($match));

			$cur = array_pop($tmp);

			if (in_array($cur, array('рублей', 'рубль', 'рубля'))) {
				$currency = Job::CUR_RUBLE;
			}
		}

		if (isset($currency)) {
			$val = implode($tmp, '');

			if (is_numeric($val)) {
				return array(
					$val,
					$currency
				);
			}
		} 

		return false;
	}

}

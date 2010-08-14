<?php

class Parser_weblancer extends Parser implements IParser {

	public function getSiteCode() {
		return 0;
	}
	
	public function getSiteName() {
		return 'WebLancer';
	}

	public function getParserName() {
		return 'WebLancer parser 0.1';
	}
	
	public function getUrl() {
		return 'http://www.weblancer.net';
	}
	
	protected function afterRequest($data) {
		return iconv('cp1251', 'utf-8', $data);
	}
	
	public function processJobList() {
		$res = $this->getRequest('http://www.weblancer.net/projects/');
	
		preg_match_all('/<a href=\"(\/projects\/(\d+).html)\"/', $res, $matches);
		
		array_shift($matches);
		
		if (0 === count($matches))
			return;

		for ($i = 0; $i < count($matches[0]); $i++ ) {
			$this->queueJobLink($matches[1][$i], 'http://www.weblancer.net' . $matches[0][$i]);
		}
	}

}

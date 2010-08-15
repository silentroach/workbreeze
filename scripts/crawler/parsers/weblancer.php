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
	
	public function getSiteFolder() {
		return 'weblancer';
	}
	
	public function getUrl() {
		return 'http://www.weblancer.net';
	}
	
	protected function afterRequest($data) {
		return iconv('cp1251', 'utf-8', $data);
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
	
	public function processJob($id, $url) {
		$res = $this->getRequest($url);
		
		if (!$res)
			return false;
			
		if (404 === $res)
			// drop queued jobs that are not found
			return true;

		$info = array(
			'id'  => $id,
			'url' => $url
		);
		
/*
<div class="title_box">
	<h1>Приложение – психологический тест на флеше</h1>
	<div class="tb_left_manage_box">
		<a href="/projects/?category_id=33">Flash</a>, 
		<a href="/projects/?category_id=59">Скрипты/Веб-приложения</a>
	</div>
s</div>
*/
		
		preg_match('/<div class=\"title_box\">(.*?)<h1>(.*?)<\/h1>/', $res, $matches);
		
		if (3 != count($matches)) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract title', 
				'page' => $res
			));
			return true;
		}
		
		$info['title'] = trim($matches[2]);
		
		preg_match_all('/<a href="\/projects\/\?category_id=(\d+)">(.*?)<\/a>/', $res, $matches);
		
		array_shift($matches);
		
		$info['categories'] = $this->checkCategories(array_combine($matches[0], $matches[1]));

		preg_match('/id_description">(.*)<a name="bid/is', $res, $matches);
		
		if (2 != count($matches)) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract description', 
				'page' => $res
			));
			return true;
		}
		
		array_shift($matches);
		
		$description = array_shift($matches);
		
		$i = mb_strpos($description, '[Приложения]');
		
		if (false !== $i) {
			$description = mb_substr($description, 0, $i) . '</div>';
		}
		
		$description = preg_replace('/<div class="disabled">(.*)<\/div>/', '', $description);
		$description = strip_tags($description, '<a>');
		$description = trim($description);
		
		$description = str_replace(array("\r\n", "\r", "\n"), '<br />', $description);

		$info['desc'] = str_replace('<br /><br />', '<br />', $description);
		
		if (preg_match('/([^ \n\r]+[ \n\r]+){30}/s', $info['desc'], $match))
			$info['short'] = $match[0] . '...';
				
		$this->addJob($info);
		
		return true;
	}

}


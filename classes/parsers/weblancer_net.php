<?php

class Parser_weblancer_net extends Parser implements IParser {

	public function getSiteCode() {
		return 0;
	}
	
	public function getSiteName() {
		return 'weblancer.net';
	}

	public function getParserName() {
		return 'WebLancer parser 0.1';
	}
	
	public function getSiteFolder() {
		return 'weblancer_net';
	}
	
	public function getUrl() {
		return 'http://www.weblancer.net';
	}
	
	public function isProxyfied() {
		return false;
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
				'msg'  => 'can\'t extract title' 
			));
			return true;
		}
		
		$title = trim($matches[2]);

		$cats = '';

		if (
			preg_match_all('/<a href="\/projects\/\?category_id=(\d+)">(.*?)</si', $res, $matches)
			&& 3 == count($matches)
		) {
			array_shift($matches);
			array_shift($matches);
			
			$cc = array_shift($matches);
			
			foreach($cc as $k) {
				$cats .= $k;
			}
		}

		preg_match('/id_description">(.*)<a name="bid/is', $res, $matches);
		
		if (2 != count($matches)) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract description' 
			));
			return true;
		}
		
		array_shift($matches);
		
		$desc = array_shift($matches);
		
		$i = mb_strpos($desc, '[Приложения]');
		
		if (false !== $i) {
			$desc = mb_substr($desc, 0, $i) . '</div>';
		}
		
		$desc = preg_replace('/<div class="disabled">(.*)<\/div>/', '', $desc);

		$job = $this->newJob();
		$job->
			setId($id)->
			setUrl($url)->
			setTitle($title)->
			setDescription($desc);
			
		if ('' != $cats) {
			$job->setCategoriesByText($cats);
		}
				
		$this->addJob($job);
		
		return true;
	}

}


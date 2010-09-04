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
		return 'Freelance Job parser 0.1';
	}
	
	public function getUrl() {
		return 'http://freelancejob.ru';
	}
	
	public function getLang() {
		return Language::RUSSIAN;
	}
	
	public function isProxyFied() {
		return false;
	}
	
	protected function afterRequest($data) {
		return iconv('cp1251', 'utf-8', $data);
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
	
	public function processJob($id, $url) {
		$res = $this->getRequest($url);
	
		if (!$res)
			return false;
			
		if (404 === $res)
			// drop queued jobs that are not found
			return true;
			
/*
<h1>Нужен интернет-магазин</h1> 
 
<table width="100%" cellpadding="5" cellspacing="1"> 
<tr> 
<td> 
Нужен интернет-магазин, корректно, просто и понятно работающий, можно шаблон без дизайна.Остальное 
обсуждается в ICQ.Ждем Ваших предложений по e-mail, ICQ,и по телефону 8-915-216-30-91.<br/><br/><br/> 
<b>Телефон:</b> 89153540853<br/><b>Город:</b> 2<br/><b>Вид предложения:</b> Удаленная работа<br/>
<b>Категория:</b> Верстка сайтов<br/><br/>Добавлено: 20.08.2010 в 16:38<br/><br/><br/><br/> 
</td> 
</tr> 
</table> 
*/

		if (
			!preg_match('/<h1>(.*?)<\/h1>/', $res, $matches)
			|| 2 != count($matches)
		) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract title' 
			));
			return true;
		}

		$title = $matches[1];
		
		$i = strpos($res, $matches[0]);
		if (false === $i) {
			// something is impossible wrong O.o
			return true;
		}
		
		$desc = mb_substr($res, $i, mb_strlen($res) - $i);
		
		$i = strpos($desc, '</table>');
		if (false === $i) {
			return true;
		}
		
		$desc = mb_substr($desc, 0, $i);
		
		if (
			!preg_match('/<td>(.*?)<\/td>/is', $desc, $matches)
			|| 2 != count($matches)
		) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract description' 
			));
			return true;
		}
		
		$desc = $matches[1];
		
		$i = strpos($desc, '<br/><br/><br/>');
		
		if (false === $i) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'no more three br in desc' 
			));
			return true;
		}

		$cts = mb_substr($desc, $i, mb_strlen($desc) - $i);		
		
		$desc = mb_substr($desc, 1, $i);
		
		// special for freelancejob.ru
		$desc = str_replace("\n", '', $desc);
		
		// categories
		$cats = '';
		
		$i = mb_strpos($cts, 'Категория:');
		
		if (false !== $i) {
			$cats = mb_substr($cts, $i, mb_strlen($cts) - $i);
		
			$i = mb_strpos($cats, 'Добавлено');
		
			if (false !== $i) {
				$cats = mb_substr($cats, 0, $i);
			}
		}		
		
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




















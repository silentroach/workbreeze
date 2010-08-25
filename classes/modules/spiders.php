<?php

class MSpiders extends Module {

	private $collector = '';

	protected function isAjax() {
		return false;
	}
	
	private function jobs($site, $folder) {
		$result = '';
		
		$c = $this->db()->jobs->
			find(
				array(
					'site' => $site
				), array(
					'id', 'title', 'desc', 'short'
				)
			)->
			sort(array('stamp' => -1))->
			limit(10);
		
		while ($info = $c->getNext()) {
			$desc = isset($info['short']) ? $info['short'] : $info['desc'];
			$desc = str_replace('.<br />', '. ', $desc);
			$desc = str_replace('<br />', '. ', $desc);
			$desc = strip_tags($desc);
		
			$this->collector .= $info['title'] . ' ' . $desc;
		
			$result .= <<<EOF
<li>
	<a class="title" href="/jobs/{$folder}/{$info['id']}.html">{$info['title']}</a>
	<br />
	{$desc}
</li>	
EOF;
		}
		
		return $result;
	}
	
	private function info() {
		$result = '';
	
		$c = $this->db()->sites->find(array(), array('code', 'name', 'folder'));
		$c->sort(array('code' => 1));
		
		while ($info = $c->getNext()) {
			$result .= <<<EOF
<li style="margin-bottom: 2em;">
	<span style="font-size: 16pt;">{$info['name']}</span>
	<ul style="margin-top: 0.5em;">
		{$this->jobs($info['code'], $info['folder'])}
	</ul>
</li>	
EOF;
		}
		
		return $result;
	}
	
	protected function runModule() {
		$info = $this->info();
		
		$c = mb_strtolower($this->collector, 'utf-8');
		
		$a = str_word_count($c, 1, 'qwertyuiopasdfghjklzxcvbnmёйцукенгшщзхъфывапролджэячсмитьбю');
		$a = array_count_values($a);
		
		foreach($a as $key => $val) {
			if (
				mb_strlen($key, 'utf-8') < 4
				|| in_array($key, array(
					'quot', 'this', 'есть', 'very'
				))
			)
				unset($a[$key]);		
		}
		
		asort($a);
		$a = array_reverse($a);
		
		$keys = array('freelance', 'фриланс', 'работа');
		$kc = 0;
		
		foreach($a as $key => $count) {
			if ($kc > 17)
				break;
			
			$kc++;
			
			$keys[] = $key;
		}
		
		$keywords = implode(',', $keys);
		
		return <<<EOF
<!DOCTYPE html>
<html>
	<title>WorkBreeze</title>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="{$keywords}">

	<link rel="stylesheet" href="/css/main.css" type="text/css" />
<body>
	<div id="logo">WorkBreeze</div>
	<br />
	
	<style>
		ul {
			padding: 0px;
		}
		
		ul li {
			margin-bottom: 1em;
		}
	</style>

	<ul style="padding: 0px">
		{$info}
	</ul>
</body>
</html>
EOF;
	}

}

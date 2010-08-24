<?php

require 'up.php';

class MInit extends MUp {

	private function getLang($ver = 0) {
		$l = array(
			'v' => 1,
			'vl' => array(
				'kwds' => 'ключевые слова через запятую',
				'on'   => 'на',
				'pl'   => 'запуск',
				'pa'   => 'пауза',
				'mt'   => 'почта'
			)
		);
		
		if ($l['v'] != $ver)
			return $l;
			
		return false;
	}

	private function getSites() {
		$db = $this->db();
		
		$c = $db->sites;
		
		$sites = array();
		
		$cursor = $c->find();
		
		while ($site = $cursor->getNext()) {
			$sites[] = array(
				'i' => $site['code'], 
				'f' => $site['folder'], 
				'n' => $site['name'], 
				'u' => $site['url']
			);
		}
		
		return $sites;
	}

	protected function runModule() {	
		$vlang = isset($_POST['lang']) ? intval($_POST['lang']) : 0;
		
		$lang = $this->getLang($vlang);
	
		$r =  array(
			's'  => $this->getSites(),
			'j'  => $this->getJobs()
		);
		
		if ($lang) {
			$r['l'] = $lang;
		}
		
		return $r;
	}

}

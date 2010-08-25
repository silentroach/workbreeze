<?php

require 'up.php';

class MInit extends MUp {

	const VSITES = 1;

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

	private function getSites($ver = 0) {
		if (self::VSITES === $ver)
			return false;
	
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
		
		return array(
			'v'  => self::VSITES,
			'vl' => $sites
		);
	}

	protected function runModule() {	
		$vlang  = isset($_POST['lang'])  ? intval($_POST['lang']) : 0;
		$vsites = isset($_POST['sites']) ? intval($_POST['sites']) : 0;
		
		$lang   = $this->getLang($vlang);
		$sites  = $this->getSites($vsites);
	
		$r = array();
		
		if ($lang) {
			$r['l'] = $lang;
		}
		
		if ($sites) {
			$r['s'] = $sites;
		}
		
		$r['j'] = $this->getJobs();
		
		return $r;
	}

}

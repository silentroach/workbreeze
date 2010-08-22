<?php

require 'up.php';

class MInit extends MUp {

	private function getLang() {
		return array(
			'kwds' => 'ключевые слова через запятую',
			'on'   => 'на',
			'pl'   => 'запустить',
			'pa'   => 'пауза'
		);
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
		return array(
			'l'  => $this->getLang(),
			's' => $this->getSites(),
			'j'  => $this->getJobs()
		);
	}

}

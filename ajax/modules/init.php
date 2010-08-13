<?php

class MInit extends Module {

	private function siteList() {
		$db = $this->db();
		
		$c = $db->parsers;
		
		$sites = array();
		
		$cursor = $c->find();
		
		while ($site = $cursor->getNext()) {
			$sites[] = array($site['code'], $site['name'], $site['url']);
		}
		
		return $sites;
	}

	protected function runModule() {
		return array(
			$this->siteList()
		);
	}

}

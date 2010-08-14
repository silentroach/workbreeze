<?php

require 'jobs.php';

class MInit extends MJobs {

	private function getSites() {
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
			$this->getSites(),
			$this->getJobs()
		);
	}

}

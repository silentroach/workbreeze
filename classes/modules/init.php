<?php

require 'up.php';

class MInit extends MUp {

	private function getSites() {
		$db = $this->db();
		
		$c = $db->sites;
		
		$sites = array();
		
		$cursor = $c->find();
		
		while ($site = $cursor->getNext()) {
			$sites[] = array(
				'id'     => $site['code'], 
				'folder' => $site['folder'], 
				'name'   => $site['name'], 
				'url'    => $site['url']
			);
		}
		
		return $sites;
	}

	protected function runModule() {
		return array(
			'sites' => $this->getSites(),
			'jobs'  => $this->getJobs()
		);
	}

}

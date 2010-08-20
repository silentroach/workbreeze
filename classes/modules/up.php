<?php

class MUp extends Module {

	protected function getJobs() {
		$stamp = isset($_POST['stamp']) ? intval($_POST['stamp']) : 0;
	
		$db = $this->db();
		
		$c = $db->jobs;
		
		$jobs = array();
		
		$cursor = $c->find(array(
			'stamp' => array(
				'$gt' => $stamp
			)
		));
		$cursor->sort(array(
			'stamp' => 0
		));
		$cursor->limit(15);
		
		while ($job = $cursor->getNext()) {
			$jobs[] = array(
				'site'  => $job['site'],
				'id'    => $job['id'],
				'stamp' => $job['stamp'],
				'title' => $job['title'],
				'desc'  => isset($job['short']) ? $job['short'] : $job['desc']
			);
		}
		
		return $jobs;
	}

	protected function runModule() {
		return 	$this->getJobs();
	}

}

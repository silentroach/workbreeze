<?php

class MJ extends Module {

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
		$cursor->limit(10);
		
		while ($job = $cursor->getNext()) {
			$jobs[] = array(
				$job['site'],
				$job['id'],
				$job['stamp'],
				$job['title'],
				isset($job['short']) ? $job['short'] : $job['desc']
			);
		}
		
		return $jobs;
	}

	protected function runModule() {
		return 	$this->getJobs();
	}

}

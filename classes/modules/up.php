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
			'stamp' => -1
		));
		$cursor->limit(15);
		
		while ($job = $cursor->getNext()) {
			$jobs[] = array(
				's'  => $job['site'],
				'i'  => $job['id'],
				'st' => $job['stamp'],
				't'  => $job['title'],
				'd'  => isset($job['short']) ? $job['short'] : $job['desc']
			);
		}
		
		return $jobs;
	}

	protected function runModule() {
		return 	$this->getJobs();
	}

}

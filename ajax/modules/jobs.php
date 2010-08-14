<?php

class MJobs extends Module {

	protected function getJobs() {
		$db = $this->db();
		
		$c = $db->jobs;
		
		$jobs = array();
		
		$cursor = $c->find();
		$cursor->sort(array(
			'stamp' => 1
		));
		$cursor->limit(10);
		
		while ($job = $cursor->getNext()) {
			$jobs[] = array(
				$job['site'],
				$job['id'],
				$job['stamp'],
				$job['name']
			);
		}
		
		return $jobs;
	}

}

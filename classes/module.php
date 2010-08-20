<?php

require(PATH_CLASSES . 'json.php');

class Module {

	private $request;
	private $db;

	public function __construct($request) {
		$this->request = $request;
	}
	
	protected function db() {
		if (!$this->db) {
			$db = new Mongo();
			$this->db = $db->selectDB(DB);
		}
		
		return $this->db;
	}
	
	protected function runModule() {
	
	}

	public function run() {
		$object = $this->runModule();
		
		if (
			is_object($object) 
			|| is_array($object)
		) {
			header('Content-Type: application/json');
			echo JSON::encode($object);
		}
	}

}

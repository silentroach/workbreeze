<?php

require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'json.php');

class Module {

	private $request;
	private $db;

	public function __construct($request) {
		$this->request = $request;
	}
	
	protected function isAjax() {
		return true;
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

	private function fail() {
	        header('HTTP/1.0 404 Not Found');
	        die();
	}

	public function run() {
		if (
			$this->isAjax()
			&& !defined('DEBUG')
			&& (
				!isset($_SERVER['HTTP_X_REQUESTED_WITH'])
				|| !isset($_SERVER['HTTP_REFERER'])
				|| !isset($_SERVER['HTTP_HOST'])
				|| 'XMLHttpRequest' !== $_SERVER['HTTP_X_REQUESTED_WITH']
				|| false !== strpos($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])
			)
		) {
			$this->fail();
		}
	
		$object = $this->runModule();
		
		if (
			is_object($object) 
			|| is_array($object)
		) {
			header('Content-Type: application/json');
			echo JSON::encode($object);
		} else {
			echo $object;
		}
	}

}

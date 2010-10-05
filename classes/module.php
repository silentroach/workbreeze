<?php

require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'json.php');
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'language.php');

class Module {

	private $app;

	public function __construct($app) {
		$this->app = $app;
	}

	protected function isAjax() {
		return true;
	}
	
	protected function db() {
		return $this->app->getDatabase();
	}
	
	protected function runModule($query) {
	
	}

	public function run($query) {
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
			header('404 Not Found');
			return;
		}
	
		$object = $this->runModule($query);
	
		if (is_array($object)) {
			if (0 === count($object)) {
				header('204 No Content');
			} else {
				header('Content-Type: application/json');
				echo JSON::encode($object);
			}
		} elseif (
			'' === $object
			|| false === $object
		) {
			header('204 No Content');
		} else {
			echo $object;
		}
	}

}

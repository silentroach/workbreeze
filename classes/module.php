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
	
	protected function runModule($request, $query) {
	
	}

	public function run($request, $query) {
		if (
			$this->isAjax()
			&& !defined('DEBUG')
			&& (
				!isset($request->attrs->server['HTTP_X_REQUESTED_WITH'])
				|| !isset($request->attrs->server['HTTP_REFERER'])
				|| !isset($request->attrs->server['HTTP_HOST'])
				|| 'XMLHttpRequest' !== $request->attrs->server['HTTP_X_REQUESTED_WITH']
				|| false !== strpos($request->attrs->server['HTTP_HOST'], $request->attrs->server['HTTP_REFERER'])
			)
		) {
			self::fail();
		}
	
		$object = $this->runModule($request, $query);
		
		if (is_array($object)) {
			if (0 === count($object)) {
				$request->status(204);
			} else {
				$request->header('Content-Type: application/json');
				$request->out(JSON::encode($object));
			}
		} elseif (
			'' === $object
			|| false === $object
		) {
			$request->status(204);
		} else {
			$request->out($object);
		}
	}

}

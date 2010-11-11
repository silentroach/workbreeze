<?php

$root = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;

require $root . 'bootstrap.php';

class WorkbreezeRequest extends HTTPRequest {
	
	public function run() {
		if (
			!isset($_SERVER['DOCUMENT_URI'])
			|| !isset($_SERVER['REQUEST_URI'])
		) {
			$this->status(404);
			return;
		}

		$uri = isset($_SERVER['DOCUMENT_URI']) ? $_SERVER['DOCUMENT_URI'] : $_SERVER['REQUEST_URI'];

		$params = explode('?', $uri);

		$query = explode('/', array_shift($params));

		array_shift($query);

		$module = array_shift($query);

		if (null === $module) {
			$this->status(404);
			return;
		}

		$m = $this->appInstance->getModule($module);

		if (!$m) {
			$this->status(404);
			return;
		}

		$m->run($query);
	}

}

class Workbreeze extends AppInstance {

	private static $modules = array();
	private $database;

	public function init() {
		$connection = new Mongo();
		$this->database = $connection->selectDB(DB);

		Daemon::log('Workbreeze up');
	}

	public function onShutdown() {
		return true;
	}

	public function beginRequest($req,$upstream) {
		return new WorkbreezeRequest($this, $upstream, $req);
	}

	public function getDatabase() {
		return $this->database;
	}

	public function getModule($module) {
		$module = strtolower($module);

		if (!isset(self::$modules[$module])) {
			$className = 'M' . ucfirst($module);

			if (!class_exists($className)) {
        			self::$modules[$module] = false;
				return false;
			}

			self::$modules[$module] = new $className($this);
		}

		return self::$modules[$module];
	}
}

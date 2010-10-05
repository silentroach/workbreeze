<?php

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

	private $modules = array();
	private $database;

	public function init() {
		$root = dirname(__FILE__) . DIRECTORY_SEPARATOR;

		require($root . 'defines.php');
		require(PATH_CLASSES . 'module.php');

		$connection = new Mongo();
		$this->database = $connection->selectDB(DB);
	}

	public function onReady() {
	
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
		if (!isset($this->modules[$module])) {
			$mname = PATH_CLASSES . 'modules' . DIRECTORY_SEPARATOR . $module . '.php';

			if (!file_exists($mname)) {
        			$this->modules[$module] = false;
				return false;
			}

			$className = 'M' . ucfirst($module);

			require($mname);

			$this->modules[$module] = new $className($this);
		}

		return $this->modules[$module];
	}
}

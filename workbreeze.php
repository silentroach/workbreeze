<?php

return new Workbreeze;

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

class WorkbreezeRequest extends Request {
	
	public function run() {
		$srv = $this->attrs->server;

		if (
			!isset($srv['DOCUMENT_URI'])
			|| !isset($srv['REQUEST_URI'])
		) {
			$this->status(404);
			return Request::DONE;
		}

		$uri = isset($srv['DOCUMENT_URI']) ? $srv['DOCUMENT_URI'] : $srv['REQUEST_URI'];

		$params = explode('?', $uri);

		$query = explode('/', array_shift($params));

		array_shift($query);

		$module = array_shift($query);

		if (null === $module) {
			$this->status(404);
			return Request::DONE;
		}

		$m = $this->appInstance->getModule($module);

		if (!$m) {
			$this->status(404);
			return Request::DONE;
		}

		$m->run($this, $query);

		return Request::DONE;
	}
}

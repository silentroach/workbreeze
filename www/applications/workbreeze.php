<?php

$root = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;

require $root . 'bootstrap.php';

/**
 * Class for the http request
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class WorkbreezeRequest extends HTTPRequest {

	/**
	 * Process the request
	 */
	public function run() {
		if (
			!isset($_SERVER['DOCUMENT_URI'])
			|| !isset($_SERVER['REQUEST_URI'])
		) {
			$this->status(404);
			return;
		}

		$uri = isset($_SERVER['DOCUMENT_URI']) ? $_SERVER['DOCUMENT_URI'] : $_SERVER['REQUEST_URI'];

		// stripping get params in url
		$params = explode('?', $uri);

		// getting the query from url
		$query = explode('/', array_shift($params));

		// shifting first useless part
		array_shift($query);

		// module is the next part
		$module = array_shift($query);

		if (!$module) {
			$module = 'home';
		}

		$m = $this->appInstance->getModule($module);

		if (!$m) {
			// module not found
			$this->status(404);
			return;
		}

		$m->run($query);
	}

}

/**
 * Workbreeze application instance
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class Workbreeze extends AppInstance {

	private static $modules = array();

	public function init() {
		Daemon::log('Workbreeze up');
	}

	public function onShutdown() {
		return true;
	}

	public function beginRequest($req, $upstream) {
		return new WorkbreezeRequest($this, $upstream, $req);
	}

	public function getModule($module) {
		$module = strtolower($module);

		if (!isset(self::$modules[$module])) {
			$className = 'M' . ucfirst($module);

			if (!class_exists($className)) {
				self::$modules[$module] = false;
				return false;
			}

			self::$modules[$module] = new $className();
		}

		return self::$modules[$module];
	}
}

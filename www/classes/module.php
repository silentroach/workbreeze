<?php

class NotFoundModuleResult { }

/**
 * Base class for modules
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com> 
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class Module {

	/**
	 * For not found result
	 * @return NotFoundModuleResult
	 */
	public static function NotFound() {
		return new NotFoundModuleResult();
	}

	/**
	 * Turn on additional checks for ajax requests
	 * @return boolean
	 */
	protected function isAjax() {
		return true;
	}

	/**
	 * Method to process module
	 */
	protected function runModule($query) {
	
	}

	/**
	 * Method to run on request 
	 */
	public function run($query) {
		if (
			$this->isAjax()
			&& !defined('DEBUG')
			&& (
				// some stupid check for ajax requests
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

		// runModule will return the module reply
		$object = $this->runModule($query);

		$this->result($object);
	}

	/**
	 * Return the content to user
	 */
	protected function result($object) {
		if (is_array($object)) {                                // array -> json object
			if (0 === count($object)) {
				header('204 No Content');
			} else {
				header('Content-Type: application/json');
				echo JSON::encode($object);
			}
		} else
		if ($object instanceof NotFoundModuleResult) {          // not found -> 404
			header('404 Not Found');
		} elseif (                                              // '' || false -> 204
			'' === $object
			|| false === $object
		) {
			header('204 No Content');
		} else {                                                // something else -> string to print
			echo $object;
		}
	}

}

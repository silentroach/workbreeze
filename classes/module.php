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
	 */
	public static function NotFound() {
		return new NotFoundModuleResult();
	}

	protected function isAjax() {
		return true;
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
		} else
		if ($object instanceof NotFoundModuleResult) {
			header('404 Not Found');
		} else
		if ($object instanceof Page) {
			echo $object->out();
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

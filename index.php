<?php

function fail() {
	header('HTTP/1.0 404 Not Found');
	die();
}

if (!isset($_SERVER['REQUEST_URI'])) {
	fail();
}

require('defines.php');

if (
	!defined('DEBUG')
	&& (
		!isset($_SERVER['HTTP_X_REQUESTED_WITH'])
		|| !isset($_SERVER['HTTP_REFERER'])
		|| !isset($_SERVER['HTTP_HOST'])
		|| 'XMLHttpRequest' !== $_SERVER['HTTP_X_REQUESTED_WITH']
		|| false !== strpos($_SERVER['HTTP_HOST'], $_SERVER['HTTP_REFERER'])
	)
) {
	fail();
}
	
$uri = $_SERVER['REQUEST_URI'];

$params = explode('?', $uri);

$query = explode('/', array_shift($params));

array_shift($query);

$module = array_shift($query);

if (null === $module) {
	fail();
}

require(PATH_CLASSES . 'module.php');

$mname = PATH_CLASSES . 'modules' . DIRECTORY_SEPARATOR . $module . '.php';

if (!file_exists($mname)) {
	fail();
}
	
$className = 'M' . ucfirst($module);
	
require($mname);

$module = new $className($query);
$module->run();

<?php

function fail() {
	header('HTTP/1.0 404 Not Found');
	die();
}

if (!isset($_SERVER['REQUEST_URI'])) {
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

require('defines.php');	
require(PATH_CLASSES . 'module.php');

$mname = PATH_CLASSES . 'modules' . DIRECTORY_SEPARATOR . $module . '.php';

if (!file_exists($mname)) {
	fail();
}
	
$className = 'M' . ucfirst($module);
	
require($mname);

$module = new $className($query);
$module->run();

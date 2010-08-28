<?php

if (
	!isset($_SERVER['DOCUMENT_URI'])
	|| !isset($_SERVER['REQUEST_URI'])
) {
	fail();
}
	
$uri = isset($_SERVER['DOCUMENT_URI']) ? $_SERVER['DOCUMENT_URI'] : $_SERVER['REQUEST_URI'];

$params = explode('?', $uri);

$query = explode('/', array_shift($params));

array_shift($query);

$module = array_shift($query);

require('defines.php');

if (null === $module) {
	Module::fail();
}

require(PATH_CLASSES . 'module.php');

$mname = PATH_CLASSES . 'modules' . DIRECTORY_SEPARATOR . $module . '.php';

if (!file_exists($mname)) {
	Module::fail();
}
	
$className = 'M' . ucfirst($module);
	
require($mname);

$module = new $className($query);
$module->run();

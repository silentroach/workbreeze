<?php

require('defines.php');
require(PATH_CLASSES . 'module.php');

if (
	!isset($_SERVER['DOCUMENT_URI'])
	|| !isset($_SERVER['REQUEST_URI'])
) {
	Module::fail();
}
	
$uri = isset($_SERVER['DOCUMENT_URI']) ? $_SERVER['DOCUMENT_URI'] : $_SERVER['REQUEST_URI'];

$params = explode('?', $uri);

$query = explode('/', array_shift($params));

array_shift($query);

$module = array_shift($query);

if (null === $module) {
	Module::fail();
}

$mname = PATH_CLASSES . 'modules' . DIRECTORY_SEPARATOR . $module . '.php';

if (!file_exists($mname)) {
	Module::fail();
}
	
$className = 'M' . ucfirst($module);
	
require($mname);

$module = new $className($query);
$module->run();

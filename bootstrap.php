<?php

if (!defined('BOOTSTRAPPED')) {

	define('BOOTSTRAPPED', 1);

	$basepath = dirname(__FILE__);
	define('DS', DIRECTORY_SEPARATOR);

	define('PATH_CLASSES', $basepath . DS . 'classes' . $ds);
	define('PATH_PUBLIC',  $basepath . DS . 'public_html' . $ds);
	define('PATH_OTHER',   $basepath . DS . 'other' . $ds);
	
	define('DB', 'breeze');

	define('DEBUG', 1);

	/* some ini settings */

	// turning off mongo warnings about non-utf8 values
	ini_set('mongo.utf8', 0);

	/* config */

	mb_regex_encoding( 'UTF-8' );
	mb_internal_encoding( 'UTF-8' );

	/* require all */

	$dirs = array(
		'classes',
		'classes/modules',
		'classes/parsers'
	);

	foreach($dirs as $dir) {
		foreach(glob(__DIR__ . $ds . $dir . DS . '*.php') as $file) {
			require $file;
		}
	}

}

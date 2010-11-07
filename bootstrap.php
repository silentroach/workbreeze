<?php

if (!defined('BOOTSTRAPPED')) {

	define('BOOTSTRAPPED', 1);

	$basepath = dirname(__FILE__);
	$ds = DIRECTORY_SEPARATOR;

	define('PATH_CLASSES', $basepath . $ds . 'classes' . $ds);
	define('PATH_PUBLIC',  $basepath . $ds . 'public_html' . $ds);
	define('PATH_OTHER',   $basepath . $ds . 'other' . $ds);
	
	define('DB', 'breeze');

	define('DEBUG', 1);

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
		foreach(glob(__DIR__ . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . '*.php') as $file) {
			require $file;
		}
	}

}

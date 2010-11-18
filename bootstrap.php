<?php

if (!defined('BOOTSTRAPPED')) {

	define('BOOTSTRAPPED', 1);

	$basepath = dirname(__FILE__);
	define('DS', DIRECTORY_SEPARATOR);

	// some useful paths
	define('PATH_CLASSES', $basepath . DS . 'classes' . DS);
	define('PATH_PUBLIC',  $basepath . DS . 'public_html' . DS);
	define('PATH_OTHER',   $basepath . DS . 'other' . DS);

	// for MongoDB
	define('DB', 'breeze');

	// for Sphinx
	define('SPHINX', '127.0.0.1:9306');
	define('IDX_JOBS', 'jobs');

	// only for debug (renamed to 'undebug' in production script)
	define('DEBUG', 1);

	// --- some ini settings

	// turning off mongo warnings about non-utf8 values
	ini_set('mongo.utf8', 0);

	// ---

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
		foreach(glob(__DIR__ . DS . $dir . DS . '*.php') as $file) {
			require $file;
		}
	}

}

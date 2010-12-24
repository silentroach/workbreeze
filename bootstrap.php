<?php

/**
 * Bootstrap for phpdaemon worker and scripts
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
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

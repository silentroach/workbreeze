<?php

if (!defined('BOOTSTRAPPED')) {

	function critlog($message) {
		if (class_exists('Daemon')) {
			Daemon::log($message);
			return false;
		} else {
			echo $message . "\n";
			die();
		}
	}

	if (
		!function_exists('stem_russian_unicode')
		|| !function_exists('stem_english')
	) {
		critlog('pecl-stem is not installed or installed not correctly (you need english and russian languages support)');
	}

	if (!function_exists('curl_init')) {
		critlog('curl support is not enabled');
	}

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

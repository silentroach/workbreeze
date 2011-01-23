<?php

define('PATH_GCC', escapeshellarg(trim(`find ./ -name 'gcc.jar'`)));
define('PATH_YUI', escapeshellarg(trim(`find ./ -name 'yui.jar'`)));

define('PATH_EXTERNS', __DIR__ . DIRECTORY_SEPARATOR . 'externs' . DIRECTORY_SEPARATOR);

function compressJS($files = array(), $rootpath = '.') {
	$compiler = 'java -jar ' . PATH_GCC . ' --compilation_level ADVANCED_OPTIMIZATIONS ' .
		'--warning_level QUIET';
		
	echo "Compressing .js...\n  ";
		
	foreach($files as $js) {
		$file = realpath($rootpath . DS . $js);
		$basename = pathinfo($file, PATHINFO_BASENAME);
		
		if ('debug.js' === $basename) {
			continue;
		}
		
		echo $basename . ' ';
		
		$compiler .= ' --js ' . escapeshellarg($file);
	}
	
	echo "\n";
	
	$externs = explode("\n", trim(shell_exec('find ' . escapeshellarg(PATH_EXTERNS) . ' -name *.js')));

	foreach($externs as $extern) {
		$compiler .= ' --externs ' . escapeshellarg($extern);
	}
	
	return shell_exec($compiler);
}

function compressCSS($files = array(), $rootpath = '.') {
	$compiler = 'java -jar ' . PATH_YUI . ' ';
		
	echo "Compressing .css...\n  ";
	
	$content = '';
		
	foreach($files as $css) {
		$file = realpath($rootpath . DS . $css);
		$basename = pathinfo($file, PATHINFO_BASENAME);
		
		echo $basename . ' ';
		
		$content .= file_get_contents($file);
	}
	
	echo "\n";
	
	$tmppath = sys_get_temp_dir() . DS . 'temp.css';
	
	file_put_contents($tmppath, $content);

	$compiler .= escapeshellarg($tmppath);
	$result = shell_exec($compiler);
	
	unlink($tmppath);

	return $result;
}

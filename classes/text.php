<?php

function wb_html_prepare($text) {
	// all links
	if (preg_match_all('/<a(.*?)href="(.*?)"(.*?)>(.*?)<\/a>/siu', $text, $matches)) {
		$urls = $matches[0];
		
		foreach($urls as $key => $url) {
			$href = $matches[2][$key];
			$val  = $matches[4][$key];
			
			$text = str_replace($url, '<a href="' . $href . '">' . $val . '</a>', $text);
		}
	}

	$text = str_replace('•', '- ', $text);
	
	$text = str_ireplace('&nbsp;', ' ', $text);
	$text = str_replace("\t", '', $text);
	
	while (false !== strpos($text, '  ')) {
		$text = str_replace('  ', ' ', $text);
	}

	$text = str_ireplace(
		array('<br />', '<br>', '<br/>'),
		"\n",
		$text
	);
	
	$text = str_ireplace(
		array('&nbsp;', '/>' , ' >', '> <', ' </'),
		array(' '     , ' />', '>' , '><' ,  '</'),
		$text
	);
	
	$text = str_replace(array(" \n", "\n "), "\n", $text);
	
	while (false !== strpos($text, "\n\n\n")) {
		$text = str_replace("\n\n\n", "\n\n", $text);
	}
	
	$text = strip_tags($text, '<a>');

	$text = str_replace("\r", "\n", $text);
	$text = str_replace(array(' . ', ' , '), array('. ', ', '), $text);
	
	$text = str_replace(array(
			'…',   '»',       '«'
		), array(
			'...', '&raquo;', '&laquo;'
		), $text);

	while (false !== strpos($text, "\n\n\n")) {
		$text = str_replace("\n\n\n", "\n\n", $text);
	}
	
	while ("\n" === mb_substr($text, strlen($text) - 1, 1)) {
		$text = mb_substr($text, 0, strlen($text) - 1);
	}
	
	while ("\n" === mb_substr($text, 0, 1)) {
		$text = mb_substr($text, 1, strlen($text) - 1);
	}

	return trim($text);
}

function wb_text_stemmer($text) {

}



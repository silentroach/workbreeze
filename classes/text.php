<?php

/**
 * Ugly class for text beautification
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 */
class Text {

	/**
	 * Lists can be started with these marks
	 */
	private static $listMarks = array(
		'-', '*', '+', '°'
	);

	/**
	 * converting lists to html
	 */
	private static function replaceLists($text) {
		$text = "\n" . $text;

		// replace non indented simple list
		$text = preg_replace("@\n-([^- ])@", "\n- $1", $text);

		$splitters = array();

		// @todo make this array static
		foreach(self::$listMarks as $splitter) {
			$i = strpos($text, "\n" . $splitter);

			if (false !== $i) {
				$splitters[$splitter] = $i;
			}
		}

		arsort($splitters);

		foreach($splitters as $splitter => $pos) {
			$text = preg_replace_callback(
				"/\n((\s?(([" . $splitter . "]) (.*?))\n)+)/siu", 
				function($match) {
					return '<ul>' . preg_replace("/^\s?(([" . $match[4] . "]) (.*?))\n/m", "<li>\\3</li>", $match[0]) . '</ul>';
				},
				$text);
		}

		$text = str_replace("<ul>\n", '<ul>', $text);

		return $text;
	}
	
	/**
	 * Replace some special signs
	 */
	private static function replaceSigns($text) {
		// (tm)
		$text = preg_replace('/([\040\t])?\(tm\)/i', '\1&trade;', $text);
	
		// (c)
		$text = preg_replace('/\((c|с)\)\s+/iu', '&copy;&nbsp;', $text);
		
		// ->
		$text = preg_replace('/(\s|\>|\&nbsp\;)\-\>(\s|\&nbsp\;|\<\/)/', '\1&rarr;\2', $text);
		
		// <-
		$text = preg_replace('/(\s|\>|\&nbsp\;)\<\-(\s|\&nbsp\;)/', '\1&larr;\2', $text);
		
		return $text;
	}
	
	/**
	 * build a correct link
	 */	
	private static function buildLink($href, $value) {
		if (strlen($value) > 50) {
			$value = substr($value, 0, 47) . '...';
		}
		
		return '<a href="' . $href . '" rel="noindex, nofollow">' . $value . '</a>';
	}
	
	/**
	 * TODO shitcode overhead, need to be optimized
	 */
	public static function HTMLPrepare($text) {
		// all links
		if (preg_match_all('/<a(.*?)href="(.*?)"(.*?)>(.*?)<\/a>/siu', $text, $matches)) {
			$urls = $matches[0];
		
			foreach($urls as $key => $url) {
				$href = $matches[2][$key];
				$val  = $matches[4][$key];

				$text = str_replace($url, self::buildLink($href, $val), $text);
			}
		}
	
		$text = str_replace("\t", '', $text);
	
		$text = str_ireplace(
			array('&nbsp;', '/>' , ' >', '> <', ' </'),
			array(' '     , ' />', '>' , '><' ,  '</'),
			$text
		);

		// replace quotes
		$text = str_replace(array(
			'»', '”'
		), '&raquo;', $text);

		$text = str_replace(array(
			'«', '“'
		), '&laquo;', $text);

		// replace some strange symbols
		$text = str_replace(array(
			'…',   '•',  '—',  'ё'
		), array(
			'...', '+ ', '- ', 'е'
		), $text);

		// replace double and more spaces
		$text = preg_replace('/(\040|\t)+/', ' ', $text);

		$text = str_ireplace(
			array('<br />', '<br>', "\r"),
			"\n",
			$text
		);

		$text = str_replace(array(" \n", "\n "), "\n", $text);
	
		while (false !== strpos($text, "\n\n\n")) {
			$text = str_replace("\n\n\n", "\n\n", $text);
		}
		
		$text = self::replaceSigns($text);
		
		$text = strip_tags($text, '<a>');

		// fixing the punctuation spaces
		$text = preg_replace('/(\040|\t|\&nbsp\;)([\,\:\.])(\s+)/', '\2\3', $text);
		$text = preg_replace('/(\040|\t|\&nbsp\;)?\,([а-яa-z0-9])/iu', ', \2', $text);

		// convert links to html
		if (preg_match_all('@([^">=])(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', $text, $matches)) {
			foreach($matches[2] as $id => $link) {
				$text = str_replace($matches[0][$id], $matches[1][$id] . 
					self::buildLink($matches[2][$id], $link),
					$text);
			}
		}

		// strip last slash from all the links
		$text = preg_replace("@/</a>@", '</a>', $text);
		
		$text = self::replaceLists($text);		

		// stripping the last string break
		while ("\n" === mb_substr($text, strlen($text) - 1, 1)) {
			$text = mb_substr($text, 0, strlen($text) - 1);
		}
	
		// stripping the first string break
		while ("\n" === mb_substr($text, 0, 1)) {
			$text = mb_substr($text, 1, strlen($text) - 1);
		}

		return trim($text);
	}

}

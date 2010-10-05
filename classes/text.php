<?php

class Text {

	private static $stemCache = array();

	public static function HTMLPrepare($text) {
		// all links
		if (preg_match_all('/<a(.*?)href="(.*?)"(.*?)>(.*?)<\/a>/siu', $text, $matches)) {
			$urls = $matches[0];
		
			foreach($urls as $key => $url) {
				$href = $matches[2][$key];
				$val  = $matches[4][$key];
			
				$text = str_replace($url, '<a href="' . $href . '">' . $val . '</a>', $text);
			}
		}
	
		$text = str_ireplace('&nbsp;', ' ', $text);
		$text = str_replace("\t", '', $text);
	
		$text = str_replace(array(
				'…',   '»',       '«',       '•'
			), array(
				'...', '&raquo;', '&laquo;', '- '
			), $text);
	
		$text = str_ireplace(
			array('&nbsp;', '/>' , ' >', '> <', ' </'),
			array(' '     , ' />', '>' , '><' ,  '</'),
			$text
		);

		while (false !== strpos($text, '  ')) {
			$text = str_replace('  ', ' ', $text);
		}

		$text = str_ireplace(
			array('<br />', '<br>', "\r"),
			"\n",
			$text
		);

		$text = str_replace(array(" \n", "\n "), "\n", $text);
	
		while (false !== strpos($text, "\n\n\n")) {
			$text = str_replace("\n\n\n", "\n\n", $text);
		}
	
		$text = strip_tags($text, '<a>');

		$text = str_replace(array(' . ', ' , '), array('. ', ', '), $text);

		while ("\n" === mb_substr($text, strlen($text) - 1, 1)) {
			$text = mb_substr($text, 0, strlen($text) - 1);
		}
	
		while ("\n" === mb_substr($text, 0, 1)) {
			$text = mb_substr($text, 1, strlen($text) - 1);
		}

		return trim($text);
	}

	private static function PrepareWordForStemming($word) {
		if (mb_substr($word, 0, 1) == '-') {
			$word = mb_substr($word, 1);
		}
		
		if (mb_substr($word, -1, 1) == '-') {
			$word = mb_substr($word, 0, mb_strlen($word) - 1);
		}
		
		return $word;
	}

	public static function ExtractWords($text) {
		$text = strip_tags($text);
		$text = html_entity_decode($text);

		$text = mb_strtolower($text);
	
		preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u", $text, $matches);
		$all = array_shift($matches);

		$en = str_word_count($text, 1, 'qwertyuiopasdfghjklzxcvbnm');
		$ru = array_diff($all, $en);
	
		$result = array();
		$ex     = array();
	
		$i = 0;
		foreach($ru as $word) {
			if (mb_strlen($word) < 3)
				continue;
			
			$word = self::PrepareWordForStemming($word);

			// todo: refactor
			
			if (!isset($ex[$word])) {
				$result['ru_' . $i++] = $word;
				$ex[$word] = 1;
			}
		}
	
		$i = 0;
		foreach($en as $word) {
			if (mb_strlen($word) < 3)
				continue;

			$word = self::PrepareWordForStemming($word);

			if (!isset($ex[$word])) {
				$result['en_' . $i++] = $word;
				$ex[$word] = 1;
			}
		}
	
		return $result;
	}

	public static function Stem($words) {
		$result = array();
		$ex = array();

		foreach($words as $key => $word) {
			if (isset(self::$stemCache[$key])) {
				$tmp = self::$stemCache[$key];
			} else {		
				if (substr($key, 0, 2) == 'ru') {
					$tmp = stem_russian_unicode($word);
				} else {
					$tmp = stem_english($word);
				}
				
				self::$stemCache[$key] = $tmp;
			}
		
			if (!isset($ex[$tmp])) {
				$result[] = $tmp;
				$ex[$tmp] = 1;
			}
		}

		return $result;
	}
}

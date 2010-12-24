<?php

/**
 * Stemmer static class
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class Stemmer {

	private $cache = array();

	private static function PrepareWordForStemming($word) {
		if (mb_substr($word, 0, 1) == '-') {
			$word = mb_substr($word, 1);
		}

		if (mb_substr($word, -1, 1) == '-') {
			$word = mb_substr($word, 0, mb_strlen($word) - 1);
		}

		if (mb_strlen($word) < 3) {
			return false;
		}

		return $word;
	}

	public static function ExtractWords($text) {
		// to strip tags more accurate for words
		$text = str_replace(
			array('<', '>'),
			array(' <', '> '),
			$text);

		$text = strip_tags($text);
		$text = html_entity_decode($text);

		$text = mb_strtolower($text);

		preg_match_all("/\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u", $text, $matches);
		$all = array_shift($matches);

		$en = str_word_count($text, 1, 'qwertyuiopasdfghjklzxcvbnm');
		$ru = array_diff($all, $en);

		$result = array();
		$ex     = array();

		$i = 0;

		foreach($ru as $word) {
			$word = self::PrepareWordForStemming($word);

			// todo refactor
			
			if (
				$word
				&& !isset($ex[$word])
			) {
				$result['ru_' . $i++] = $word;
				$ex[$word] = 1;
			}
		}

		$i = 0;

		foreach($en as $word) {
			$word = self::PrepareWordForStemming($word);

			if (
				$word
				&& !isset($ex[$word])
			) {
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
			if (isset(self::$cache[$word])) {
				$tmp = self::$cache[$word];
			} else {
				if (substr($key, 0, 2) == 'ru') {
					$tmp = stem_russian_unicode($word);
				} else {
					$tmp = stem_english($word);
				}

				self::$cache[$word] = $tmp;
			}

			if (!isset($ex[$tmp])) {
				$result[] = $tmp;
				$ex[$tmp] = 1;
			}
		}

		return $result;
	}

}

<?php

/**
 * Language class
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class Language {

	private static $cache = array();

	private static $map = array(
		'uk' => 'ru',
		'ru' => 'ru',
		'be' => 'ru'
	);

	private static function parseData($data, $path) {
		$out = array();

		foreach($data as $key => $value) {
			if (is_array($value)) {
				$out = array_merge($out, self::parseData($value, $key . '/'));
			} else {
				$out[$key] = $value;
			}
		}

		return $out;
	}

	private static function checkLang($lang) {
		if (!isset(self::$cache[$lang])) {
			$filename = PATH_LANG . $lang . '.yaml';

			if (!file_exists($filename)) {
				self::$cache[$lang] = false;
				return false;
			}

			$data = Spyc::YAMLLoad($filename);

			$cache[$lang] = self::parseData($data, '');		
		}

		if (!self::$cache[$lang]) {
			return false;
		}

		return true;
	}

	public static function getValue($lang, $path) {
		if (isset(self::$cache[$lang][$path])) {
			return self::$cache[$lang][$path];
		}	

		return false;
	}

	public static function getUserLanguage() {
		$lng = 'en';

		if (
			isset($_COOKIE['lang'])
			&& self::checkLang($_COOKIE['lang'])
		) {
			return $_COOKIE['lang'];
		}
	
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

			foreach(self::$map as $alias => $target) {
				if (false !== strpos($lang, $alias)) {
					$lng = $target;
					break;
				}
			}

			setcookie('lang', $lng, 60 * 60 * 24 * 7);
		}

		if (self::checkLang($lng)) {
			return $lng;
		}

		return false;
	}

}

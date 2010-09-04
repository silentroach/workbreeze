<?php

class Language {

	const ENGLISH = 'en';
	const RUSSIAN = 'ru';
	
	const VERSION = 5;
	
	private static $lang = null;
	
	private static $list = array(
		self::ENGLISH => 'english',
		self::RUSSIAN => 'русский'
	);
	
	private static function _english() {
		return array(
			'kwds' => 'keywords separated by comma',
			'on'   => 'at',
			'pl'   => 'start',
			'pa'   => 'pause',
			'mt'   => 'mail',
			
			'c' . Job::CAT_OTHER       => 'other',
			'c' . Job::CAT_AUDIOVIDEO  => 'audio/video',
			'c' . Job::CAT_DESIGN      => 'design',
			'c' . Job::CAT_PHOTO       => 'photo',
			'c' . Job::CAT_PROGRAMMING => 'programming',
			'c' . Job::CAT_WEBPROG     => 'web-development',
			'c' . Job::CAT_TRANSLATE   => 'translation',
			'c' . Job::CAT_TEXT        => 'text work',
			'c' . Job::CAT_ADVERTISING => 'advertisements',
			'c' . Job::CAT_SYSADM      => 'system administration'
		);	
	}
	
	private static function _russian() {
		return array(
			'kwds' => 'ключевые слова через запятую',
			'on'   => 'на',
			'pl'   => 'запуск',
			'pa'   => 'пауза',
			'mt'   => 'почта',
			
			'c' . Job::CAT_OTHER       => 'прочее',
			'c' . Job::CAT_AUDIOVIDEO  => 'аудио/видео',
			'c' . Job::CAT_DESIGN      => 'дизайн',
			'c' . Job::CAT_PHOTO       => 'фото',
			'c' . Job::CAT_PROGRAMMING => 'программирование',
			'c' . Job::CAT_WEBPROG     => 'веб-разработка',
			'c' . Job::CAT_TRANSLATE   => 'перевод',
			'c' . Job::CAT_TEXT        => 'работа с текстом',
			'c' . Job::CAT_ADVERTISING => 'реклама',
			'c' . Job::CAT_SYSADM      => 'администрирование'
		);
	}
	
	public static function getLang($lang = false) {
		if (!$lang) {
			$lang = self::getUserLanguage();
		}
	
		if (self::RUSSIAN == $lang)
			return self::_russian();
		else
			return self::_english();
	}
	
	public static function getUserLanguage() {
		if (!is_null(self::$lang)) {
			return self::$lang;
		}
	
		if (
			isset($_COOKIE)
			&& isset($_COOKIE['lang'])
			&& in_array($_COOKIE['lang'], array_keys(self::$list))
		) {
			return $_COOKIE['lang'];
		}
	
		if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) 
			$lng = self::ENGLISH;
		else {			
			$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		
			if (
				false !== strpos('uk', $lang)
				|| false !== strpos('ru', $lang)
				|| false !== strpos('be', $lang)
			) {
				$lng = self::RUSSIAN;
			} else {
				$lng = self::ENGLISH;
			}
		}
		
		self::$lang = $lng;
		setcookie('lang', $lng, time() + 60 * 60 * 24); // language cookie for 1 hour
		return $lng;	
	}

}

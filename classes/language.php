<?php

class Language {

	const ENGLISH = 'en';
	const RUSSIAN = 'ru';
	
	const VERSION = 6;
	
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
			
			'hk'   => 'Example: <span class="ex">word1, !word2</span><br />will be found jobs contains [word1] and <strong>not</strong> contains [word21]',
			'hs'   => 'Site list. Everything is trigger.',
			'hc'   => 'Category list. Everything is trigger.',
			'hj'   => 'Job list. You can get a full info by clicking on the header. You can scroll it down forever.',
			
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
			
			'hk'   => 'Пример: <span class="ex">слово1, !слово2</span><br />найдутся задания, в содержимом которого упоминается [слово1] и <strong>не</strong> упоминается [слово2].',
			'hs'   => 'Список сайтов, каждый элемент - переключатель.',
			'hc'   => 'Список категорий предложений, каждый элемент - переключатель.',
			'hj'   => 'Список предложений, для просмотра полной информации следует щелкнуть по заголовку. Можно прокручивать вниз до бесконечности.',
			
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
				false !== strpos($lang, 'uk')
				|| false !== strpos($lang, 'ru')
				|| false !== strpos($lang, 'be')
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

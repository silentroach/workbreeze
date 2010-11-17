<?php

class Language {

	const ENGLISH = 'en';
	const RUSSIAN = 'ru';
	
	const VERSION = 11;

	// TODO make translations as a separate project as non-php files

	public static $list = array(
		self::ENGLISH => 'english',
		self::RUSSIAN => 'русский'
	);

	private static function _english() {
		return array(
			'_'    => self::ENGLISH,

			'kwds' => 'keywords separated by comma',
			'on'   => 'at',
			'pl'   => 'start',
			'pa'   => 'pause',
			'h'    => 'help hints',
			's'    => 'statistics',
			'y'    => 'yesterday',
			'fm'   => 'filter mode',
			
			'hk'   => 'Example: <span class="ex">word1, word2</span><br />The offers containing [word1] <strong>or</strong> [word2] will be found.',
			'hs'   => '<strong>Site list</strong>. Each element is a trigger.',
			'hc'   => '<strong>Offers category list</strong>. Each element is a trigger.',
			'hj'   => '<strong>Offers list</strong>. Fresh offers are wider than other for half a minute. Click the title to have more information. You can scroll it down endlessly.',
			'hf'   => '<strong>Filter mode</strong> allow you to receive offers only appropriate with filter settings.',
			
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
			'_'    => self::RUSSIAN,

			'kwds' => 'ключевые слова через запятую',
			'on'   => 'на',
			'pl'   => 'запуск',
			'pa'   => 'пауза',
			'h'    => 'подсказки',
			's'    => 'статистика',
			'y'    => 'вчера',
			'fm'   => 'режим фильтра',
			
			'hk'   => 'Пример: <span class="ex">слово1, слово2</span><br />Найдутся предложения, в содержимом которого упоминается [слово1] <strong>или</strong> [слово2].',
			'hs'   => '<strong>Список сайтов</strong>, где каждый элемент - переключатель.',
			'hc'   => '<strong>Список категорий предложений</strong>, где каждый элемент - переключатель.',
			'hj'   => '<strong>Список предложений</strong>. Свежие предложения на 30 секунд выделяются шириной. Для просмотра полной информации следует щелкнуть по заголовку. Прокручивать список вниз можно до бесконечности.',
			'hf'   => 'В <strong>режиме фильтра</strong> предложения, не подходящие под указанные выше критерии отбора не отображаются на экране.',
			
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

			setcookie('lang', $lng, 60 * 60 * 24 * 7, '/up');
		}
		
		return $lng;	
	}

}

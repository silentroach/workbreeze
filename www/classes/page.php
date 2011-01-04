<?php

/**
 * Page
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class Page {

	private static $files = array();

	private $title        = '';
	private $content      = '';
	private $lang         = 'ru,en';
	private $description  = '';
	private $showlogo     = true;
	private $ga           = 'ga.js';
	private $js           = array();
	
	public static function compress($content) {
		$content = str_replace(array("\t", "\r", "\n"), '', $content);
		
		while (false !== strpos($content, '  ')) {
			$content = str_replace('  ', ' ', $content);
		}

		$content = str_replace(' = ', '=', $content);
		$content = str_replace('> <', '><', $content);
		
		return $content;
	}

	public function addJS($js) {
		$this->js[] = $js;
	}

	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setContent($content) {
		$this->content = $content;
	}
	
	public function setLang($lang) {
		$this->lang = $lang;
	}
	
	public function setDescription($desc) {
		$this->description = $desc;
	}

	public function setAnalyticsScript($ga) {
		$this->ga = $ga;
	}
	
	public function disableLogo() {
		$this->showlogo = false;
	}
	
	public function out($compress = true) {
		$title = $this->title !== '' ? ' &mdash; ' . $this->title : '';
		$description = $this->description === '' ? '' : <<<EOF
<meta name="description" content="{$this->description}" />
EOF;

		$lang = $this->lang === '' ? '' : <<<EOF
<meta http-equiv="Content-Language" Content="{$this->lang}" />
EOF;

		if (!defined('DEBUG')) {
			if (!isset(self::$files[$this->ga])) {
				self::$files[$this->ga] = file_get_contents(PATH_OTHER . $this->ga);
			}

			$ga = self::$files[$this->ga];
		} else {
			$ga = '';
		}

		$logo = $this->showlogo ? '<div id="logo"><a href="/">Workbreeze</a></div>' : '';

		$js = '';

		while ($tmp = array_pop($this->js)) {
			$js .= <<<EOF
<script language="javascript" src="{$tmp}"></script>
EOF;
		}

		$content = <<<EOF
<!DOCTYPE html>
<html>
<head>
	<title>Workbreeze{$title}</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	{$description}	
	{$lang}

	<link rel="stylesheet" href="/css/main.css" type="text/css" />
	<link rel="icon" type="image/png" href="/favicon.png" />	
	<link rel="home" href="/" /> 
</head>
<body>
{$js}
{$logo}

{$this->content}

{$ga}
</body>
</html>
EOF;

		if (
			!defined('DEBUG')
			&& $compress
		) {
			$content = self::compress($content);			
		}

		return $content;
	}

}

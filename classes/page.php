<?php

/**
 * Page
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 */
class Page {

	private static $ga   = '';

	private $title       = '';
	private $content     = '';
	private $lang        = 'ru,en';
	private $description = '';
	private $showlogo    = true;
	
	public static function compress($content) {
		$content = str_replace(array("\t", "\r", "\n"), '', $content);
		
		while (false !== strpos($content, '  ')) {
			$content = str_replace('  ', ' ', $content);
		}

		$content = str_replace(' = ', '=', $content);
		$content = str_replace('> <', '><', $content);
		
		return $content;
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
	
	public function disableLogo() {
		$this->showlogo = false;
	}
	
	public function save($filename, $gzip = true) {
		$content = $this->out();
		
		file_put_contents($filename, $content);
		
		$out = system('gzip -c9 ' . escapeshellarg($filename) . ' > ' . escapeshellarg($filename . '.gz'));
	}
	
	public function out($compress = true) {
		$title = $this->title !== '' ? '&mdash; ' . $this->title : '';
		$description = $this->description === '' ? '' : <<<EOF
<meta name="description" content="{$this->description}" />
EOF;

		$lang = $this->lang === '' ? '' : <<<EOF
<meta http-equiv="Content-Language" Content="{$this->lang}" />
EOF;

		if (self::$ga === '') {
			self::$ga = file_get_contents(PATH_OTHER . 'ga.js');
		}
		
		$ga = self::$ga;

		$logo = $this->showlogo ? '<div id="logo"><a href="/">Workbreeze</a></div>' : '';

		$content = <<<EOF
<!DOCTYPE html>
<html>
	<title>WorkBreeze {$title}</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	{$description}	
	{$lang}

	<link rel="stylesheet" href="/css/main.css" type="text/css" />

	<link rel="home" href="/" /> 
<body>

{$logo}

{$this->content}

{$ga}
</body>
</html>
EOF;

		if ($compress) {
			$content = self::compress($content);			
		}

		return $content;
	}

}

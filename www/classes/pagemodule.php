<?php

/**
 * Base class for page modules
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com> 
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class PageModule extends Module {

	/**
	 * Language id
	 */
	protected $langId = '';

	/**
	 * Module file modification time
	 */
	private static $mtime = 0;
	
	/**
	 * File cache
	 */
	private static $files = array();
	
	/**
	 * Page result content
	 */
	private $content = '';
	
	/**
	 * Don't use ajax checks
	 */
	protected function isAjax() {
		return false;
	}
	
	protected function prepare($query) {
		return true;
	}
	
	protected function getTitle() {
		return false;
	}
	
	public function getJS() {  // public for build script
		return false;
	}	
	
	protected function getExternalJS() {
		return false;
	}
	
	protected function getAnalytics() {
		return 'ga.js';
	}
	
	protected function getLanguage() {
		return false;
	}
	
	protected function getContent() {
		return '';
	}
	
	protected function getShowLogo() {
		return true;
	}
	
	protected function getScript() {
		return false;
	}
	
	protected function tr($path) {
		return Language::getValue($this->langId, $path);
	}
	
	public static function compress($content) {
		$content = str_replace(array("\t", "\r", "\n"), '', $content);
		
		$content = preg_replace('/(\040|\t)+/', ' ', $content);

		$content = str_replace(' = ', '=', $content);
		$content = str_replace('> <', '><', $content);
		
		return $content;
	}	
	
	private function prepareBottomScript() {
		$script = '';
	
		// prepare language
	
		$lang = $this->getLanguage();
		
		if ($lang) {
			$langVals = array();

			foreach ($lang as $langPath => $langAlias) {
				$langVal = $this->tr($langPath);
				$langVal = str_replace('\'', '\\\'', $langVal);
				
				$langVals[] = '\'' . $langAlias . '\':\'' . $langVal . '\'';
			}
			
			$script .= '<script language="javascript">var i18n_wb={' . implode($langVals, ',') . '};</script>';
		}
		
		// + jquery support
		
		$script .= <<<EOF
<script language="javascript" src="/js/jquery.js"></script>
EOF;

		// + module external js files
		
		$extjs = $this->getExternalJS();
		
		if ($extjs) {
			foreach($extjs as $file) {
				$script .= '<script language="javascript" src="' . $file . '"></script>';
			}
		}

		// + module js files
		
		$extjs = $this->getJS();
		
		if ($extjs) {
			foreach($extjs as $file) {
				$script .= '<script language="javascript" src="/js/' . $file . '.js"></script>';
			}
		}
		
		// + script
		
		$sc = $this->getScript();
		
		if ($sc) {
			if (is_array($sc)) {
				foreach($sc as $sctmp) {
					$script .= '<script language="javascript">' . $sctmp . '</script>';
				}
			} else 
				$script .= '<script language="javascript">' . $sc . '</script>';
		}
		
		// + google analytics code
	
		if (!defined('DEBUG')) {
			$ga = $this->getAnalytics();
			
			if ($ga) {
				if (!isset(self::$files[$ga])) {
					self::$files[$ga] = file_get_contents(PATH_OTHER . $ga);
				}

				$script .= '<script language="javascript">' . self::$files[$ga] . '</script>';
			}
		}
		
		return $script;
	}
	
	private function generatePage() {
		if ($title = $this->getTitle()) {
			$title = ' &mdash; ' . $title;
		} else {
			$title = '';
		}
		
		$script = $this->prepareBottomScript();
		
		$logo = $this->getShowLogo() ? '<div id="logo"><a href="/">Workbreeze</a></div>' : '';
		
		$content = $this->getContent();
		
		return <<<EOF
<!DOCTYPE html>
<html>
<head>
	<title>Workbreeze{$title}</title>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="/css/main.css" type="text/css" />
	<link rel="icon" type="image/png" href="/favicon.png" />	
	<link rel="home" href="/" /> 	
</head>
<body>
{$logo}

{$content}

{$script}
</body>
</html>
EOF;
	}

	protected function runModule($query) {
		$this->mtime = filemtime(__FILE__);
	
		$this->langId = Language::getUserLanguage();
		
		if (!$this->prepare($query)) {
			return false;
		}		

		return $this->generatePage();
	}

	/**
	 * Print result page to user
	 */
	protected function result($object) {
		if (false === $object) {
			header('404 Not Found');
			return;
		}
	
		if (defined('DEBUG')) {
			echo $object;
		} else {
			echo $this->compress($object);
		}
	}

}

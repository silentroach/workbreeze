<?php

/**
 * Base class for page modules
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com> 
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class PageModule extends Module {

	const COMPRESS = 1;
	const KEEPNAME = 2;

	private static $mtime = 0;

	private $page;
	private $cachekey;
	private $langId;

	private $initScript;

	/**
	 * Don't use ajax checks
	 */
	protected function isAjax() {
		return false;
	}

	protected function getJS() {

	}

	protected function getLanguage() {
		return false;
	}

	protected function getTitle() {
		return false;
	}

	protected function cacheTime() {
		return -1;
	}

	protected function checkMTime() {
		return false;
	}

	protected function _generatePage() {
		$lang = $this->getLanguage();

		if ($lang) {
			$this->initScript .= <<<EOF
var wb_i18n = wb_i18n || [];
EOF;

			foreach($lang as $langPath => $langKey) {
				$langVal = Language::getValue($langPath);

				$langVal = str_replace('\'', '\\\'', $langVal);

				$this->initScript .= <<<EOF
wb_i18n['{$langKey}'] = '{$langVal}';
EOF;
			}
		}

		$this->page->setContent($content);
	}

	protected function runModule($query) {
		$this->langId = Language::getUserLanguage();

		$this->page = new Page();

		/*
		if ($this->cacheTime() > -1) {
			$this->cacheKey = get_class($this) . '_' . $this->langId;

			if ($data = Cache::get($this->cacheKey)) {
				$this->page->setContent($data);
			}
		}
		 */

		$this->_generatePage();
	}

	/**
	 * Print result page to user
	 */
	protected function result($object) {
		echo $this->page->out();
	}

}

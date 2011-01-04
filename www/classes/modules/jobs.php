<?php

/**
 * Class for jobs module
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class MJobs extends PageModule {

	private static $sites = array();
	
	private $preview = false;
	
	private $job;
	private $site;

	protected function getAnalytics() {
		return 'ga_jobs.js';
	}
	
	protected function getShowLogo() {
		return !$this->preview;
	}
	
	protected function getTitle() {
		return $this->job['title'];
	}
	
	protected function prepare($query) {
		$this->preview = isset($_GET['preview']);
		
		$site = array_shift($query);
		$id   = array_shift($query);

		if (
			!$site
			|| !$id
			|| (
				isset(self::$sites[$site])
				&& !self::$sites[$site]
			)
		) {
			return Module::NotFound();
		}

		if (!isset(self::$sites[$site])) {
			self::$sites[$site] = Database::sites()->findOne(array('folder' => $site));
		}

		$this->site = self::$sites[$site];

		if (!$this->site) {
			return false;
		}

		$this->job = Database::jobs()->findOne(array(
			'site' => (int) $this->site['code'],
			'id'   => (string) $id
		) );

		if (!$this->job) {
			return false;
		}
		
		return true;
	}
	
	protected function getContent() {
		$description = str_replace("\n", '<br />', $this->job['desc']);
		$title = $this->job['title'];

		if (isset($this->job['money'])) {
			switch($this->job['money'][1]) {
				// TODO refactor currency names

				case Job::CUR_DOLLAR:
					$currency = '$%d';
					break;
				case Job::CUR_EURO:
					$currency = '&euro;%d';
					break;
				case Job::CUR_RUBLE:
					$currency = '%d руб.';
					break;
			}

			if (isset($currency)) {
				$title .= ' [ ' . sprintf($currency, $this->job['money'][0]). ' ]';
			}
		}

		$target = $this->preview ? ' target="_blank"' : '';

		$content = <<<EOF
<p class="title">{$title}</p>

{$description}
<br /><br />

<a href="{$this->job['url']}" class="sico sico_{$this->site['code']}"{$target}>{$this->site['name']}</a>
EOF;

		return $content;
	}

}

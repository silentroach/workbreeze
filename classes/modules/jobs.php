<?php

/**
 * Class for jobs module
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class MJobs extends Module {

	private static $sites = array();

	/**
	 * Run the module
	 * @param array Query array.
	 */
	protected function runModule($query) {
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

		$preview = isset($_GET['preview']);

		if (!isset(self::$sites[$site])) {
			self::$sites[$site] = Database::sites()->findOne(array('folder' => $site));
		}

		$site = self::$sites[$site];

		if (!$site) {
			return Module::NotFound();
		}

		$job = Database::jobs()->findOne(array(
			'site' => (int) $site['code'],
			'id'   => (string) $id
		) );

		if (!$job) {
			return Module::NotFound();
		}

		$description = str_replace("\n", '<br />', $job['desc']);
		$title = $job['title'];

		if (isset($job['money'])) {
			switch($job['money'][1]) {
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
				$title .= ' [ ' . sprintf($currency, $job['money'][0]). ' ]';
			}
		}

		$target = $preview ? ' target="_blank"' : '';

		$content = <<<EOF
<p class="title">{$title}</p>

{$description}
<br /><br />

<a href="{$job['url']}" class="sico sico_{$site['code']}"{$target}>{$site['name']}</a>
EOF;

		$page = new Page();

		if ($preview) {
			$page->disableLogo();
		}

		$page->setTitle($job['title']);
		$page->setContent($content);
		$page->setLang($site['lang']);

		return $page;
	}

}

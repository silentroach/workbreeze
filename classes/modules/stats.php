<?php

/**
 * Class for statistics module
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class MStats extends Module {

	/**
 	 * Don't check for ajax request
	 */
	protected function isAjax() {
		return false;
	}

	/**
 	 * Get the cacheble page content
	 */
	private function getPageContent(array $lang) {
		$sites = Database::sites()->find()->sort(array('code' => 1));

		$content = <<<EOF
<script type="text/javascript">
google.load('visualization', '1', {packages: ['corechart']});
</script>

<p class="title">{$lang['sdw']}</p>

<div id="weekjobs"></div>

<script language="javascript">
var data = new google.visualization.DataTable();
data.addColumn('string', 'date');
EOF;

		while ($site = $sites->getNext()) {
			$content .= <<<EOF
data.addColumn('number', '{$site['name']}');

EOF;
		}

		$content .= <<<EOF
data.addRows(7);
EOF;

		$sites->reset();

		$now = getdate();
		$dt = mktime(0, 0, 0, $now['mon'], $now['mday'], $now['year']);

		$i = 6; // week for stats

		while ($i > -1) {
			$dth = date('d.m', $dt);

			$content .= <<<EOF
data.setValue({$i}, 0, '{$dth}');

EOF;

			$n = 1;
			while ($site = $sites->getNext()) {
				$c = Database::jobs()->find( array( 
					'site'   => $site['code'],
					'stamp'  => array(
						'$gte' => $dt,
						'$lt'  => $dt + 60 * 60 * 24
					)
				) )->count();

				$content .= <<<EOF
data.setValue({$i}, {$n}, {$c});

EOF;

				++$n;
			}

			$sites->reset();
			--$i;
			$dt -= 60 * 60 * 24;
		}

		$content .= <<<EOF
new google.visualization.LineChart(
	document.getElementById('weekjobs')
).draw(data, {
	height: 350,
	width: 800,
	backgroundColor: {
		stroke: '#858585',
		strokeWidth: 1,
		fill: '#2e3436'
	},
	legendTextStyle: {
		color: 'white'
	},
	vAxis: {
		baselineColor: '#858585',
		textStyle: {
			color: 'white'
		}
	},
	hAxis: {
		baselineColor: '#858585',
		textStyle: {
			color: 'white'
		}
	},
	curveType: 'function',
	chartArea: {
		left: 60,
		top: 55,
		width: 550
	},
	pointSize: 3,
	fontName: 'Tahoma',
	min: 0,
	legend: 'right'
});
</script>
EOF;

		return $content;
	}

	/**
 	 * Run the module
	 * @param array Query array.
	 */
	protected function runModule($query) {
		$langid = Language::getUserLanguage();
		$lang = Language::getLang($langid);

		$cacheKey = 'stats_' . $langid;

		$content = Cache::get($cacheKey);

		if (!$content) {
			$content = $this->getPageContent($lang);

			Cache::set($cacheKey, $content, 60 * 60 * 10); // 10 minutes cache
		}

		$page = new Page();

		$page->setTitle($lang['s']);
		$page->addJS('http://www.google.com/jsapi');
		$page->setContent($content);

		return $page;
	}

}

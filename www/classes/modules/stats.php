<?php

/**
 * Class for statistics module
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class MStats extends PageModule {

	protected function getScript() {
		$sites = Database::sites()->find()->sort(array('code' => 1));
	
		$content = <<<EOF
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
EOF;

		return array(
			'google.load(\'visualization\', \'1\', {packages: [\'corechart\']});',
			$content
		);
	}
	
	protected function getExternalJS() {
		return array(
			'http://www.google.com/jsapi'
		);
	}

	protected function getContent() {
		$content = <<<EOF
<p class="title">{$this->tr('statistics/daily')}</p>

<div id="weekjobs"></div>
EOF;

		return $content;
	}

}

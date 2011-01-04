<?php

/**
 * Something like scheduler
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
class Scheduler {

	private $parsers;

	private function initParser($info) {
		if (!isset($this->parsers[$info['code']])) {	
			$this->parsers[$info['code']] = new $info['class']();
		}
		
		return $this->parsers[$info['code']];
	}

	// @todo refactor
	public function updateGlobalRSS() {
		echo '[' . date('H:m:s') . "] Updating global RSS channel...\n";

		$filename = PATH_PUBLIC . 'rss-global.xml';		

		$sites = Database::sites();
		
		$st = array();
		
		$cursor = Database::jobs()->find();
		$cursor->sort(array('stamp' => -1));
		$cursor->limit(25);
		
		date_default_timezone_set('GMT');
		
		// generating global rss feed
		
		$rss = RSS::create($filename);
		
		while ($item = $cursor->getNext()) {		
			$writer->startElement('item');
			
			if (!isset($st[$item['site']])) {
				$st[$item['site']] = $sites->findOne(array('code' => $item['site']));
			}
			
			$s = $st[$item['site']];
			
			$desc = <<<EOF
{$item['desc']}<br /><p style="padding: 0.2em; background-color: silver; border: 1px dotted black; align: center;" align="center"><a href="{$item['url']}">{$item['title']}</a></p>
EOF;
			
			$rss->addItem(
				$s['name'] . ': ' . $item['title'],
				'http://workbreeze.com/jobs/' . $s['folder'] . '/' . $item['id'],
				$desc,
				'http://workbreeze.com/jobs/' . $s['folder'] . '/' . $item['id'],
				$item['stamp']
			);
		}
		
		$rss->save();

		// compressing for nginx static gzip
		$out = system('gzip -c9 ' . escapeshellarg($filename) . ' > ' . escapeshellarg($filename . '.gz'));
	}

	public function processJobList() {
		$c = Database::sites()->find();

		while ($site = $c->getNext()) {
			if (
				isset($site['disabled']) 
				&& 1 == $site['disabled']
			) {
				continue;
			}

			$parser = $this->initParser($site);
		
			if (
				isset($site['stamp'])
				&& (time() - (int) $site['stamp']) < $parser->getUpdatePeriod() - 1
			) {
				continue;
			}

			echo '[' . date('H:m:s') . '] Process main pages for ' . $site['name'] . "\n";
			
			Database::sites()->update(
				array('code' => $site['code']),
				array('$set' => 
					array(
						'stamp' => time()
					)
				)
			);

			$parser->processJobList();
		}
	}
	
	public function processQueue() {	
		$queue = Database::queue();
		$sites = Database::sites();
		
		$c = $queue->find();
		$c->sort(array('rnd' => 1));
		$c->limit(20);
		
		$cnt = 0;

		while ($item = $c->getNext()) {
			$cnt++;

			$site = $sites->findOne(array('code' => $item['site']));
			
			if (null === $site)
				continue;
				
			$parser = $this->initParser($site);
			
			if ('job' === $item['type']) {
				$time = time();

				if ($parser->processJob($item['id'], $item['url'])) {
					$queue->remove(array('_id' => $item['_id']));	

					// stamps must be unique
					while (time() == $time) {
						sleep(1);
					}
				}
			}
		}

		if ($cnt > 0) {
			$this->updateGlobalRSS();
		}
	}

}

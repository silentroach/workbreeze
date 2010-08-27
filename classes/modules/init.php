<?php

require 'up.php';
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'job.php';

class MInit extends MUp {

	const VSITES = 1;
	const VCATS  = 1;

	private function getLang($ver = 0) {
		$l = array(
			'v' => 2,
			'vl' => array(
				'kwds' => 'ключевые слова через запятую',
				'on'   => 'на',
				'pl'   => 'запуск',
				'pa'   => 'пауза',
				'mt'   => 'почта',
				
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
			)
		);
		
		if ($l['v'] != $ver)
			return $l;
			
		return false;
	}
	
	private function getCats($ver = 0) {
		if (self::VCATS === $ver)
			return false;
			
		$items = array();
		
		foreach(array(
			Job::CAT_OTHER, Job::CAT_AUDIOVIDEO, Job::CAT_DESIGN, Job::CAT_PHOTO, Job::CAT_PROGRAMMING, 
			Job::CAT_WEBPROG, Job::CAT_TRANSLATE, Job::CAT_TEXT, Job::CAT_ADVERTISING, Job::CAT_SYSADM
		) as $el) {
			$items['c' . $el] = $el;
		}
			
		return array(
			'v' => self::VCATS,
			'vl' => $items
		);
	}

	private function getSites($ver = 0) {
		if (self::VSITES === $ver)
			return false;
	
		$db = $this->db();
		
		$c = $db->sites;
		
		$sites = array();
		
		$cursor = $c->find();
		
		while ($site = $cursor->getNext()) {
			$sites[] = array(
				'i' => $site['code'], 
				'f' => $site['folder'], 
				'n' => $site['name'], 
				'u' => $site['url']
			);
		}
		
		return array(
			'v'  => self::VSITES,
			'vl' => $sites
		);
	}

	protected function runModule() {	
		$vlang  = isset($_POST['lang'])  ? intval($_POST['lang']) : 0;
		$vsites = isset($_POST['sites']) ? intval($_POST['sites']) : 0;
		$vcats  = isset($_POST['cats'])  ? intval($_POST['cats']) : 0;
		
		$lang   = $this->getLang($vlang);
		$sites  = $this->getSites($vsites);
		$cats   = $this->getCats($vcats);
	
		$r = array();
		
		if ($lang) {
			$r['l'] = $lang;
		}
		
		if ($sites) {
			$r['s'] = $sites;
		}
		
		if ($cats) {
			$r['c'] = $cats;
		}
		
		$r['j'] = $this->getJobs();
		
		return $r;
	}

}

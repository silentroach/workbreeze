<?php

require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'stemmer' . DIRECTORY_SEPARATOR . 'stemmer_ru.php');
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'stemmer' . DIRECTORY_SEPARATOR . 'stemmer_en.php');

class Stemmer {
	
	private $cache = array();

	private $stemmers;
	
	public function __construct() {
		$this->stemmers['ru'] = new Stemmer_RU();
		$this->stemmers['en'] = new Stemmer_EN();
	}

}

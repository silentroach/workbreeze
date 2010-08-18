<?php

class Job {

	private $description;
	private $description_short = '';
	
	public static function create() {
		return new Job();
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($text = '') {
		$text = trim($text);
		
		while (false !== strpos($text, '  ')) {
			$text = str_replace('  ', ' ', $text);
		}
	
		$text = str_replace(
			array(' />', '<br/>', '<br>', '> ', ' </'),
			array('/>' , "\n"   , "\n"  , '>' ,  '</'),
			$text
		);
		
		while (false !== strpos($text, "\n\n\n")) {
			$text = str_replace("\n\n\n", "\n\n", $text);
		}
		
		$text = strip_tags($text, '<a>');
		
		$text = str_replace(array("\r\n", "\r", "\n"), '<br />', $text);
		
		$this->description = trim($text);
		
		if (preg_match('/([^ \n\r]+[ \n\r]+){30}/s', $text, $match))
			$this->description_short = $match[0] . '...';
		
		return $this;
	}

}

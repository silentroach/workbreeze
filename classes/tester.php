<?php

require(PATH_CLASSES . 'job.php');

class Tester {

	private $job;
	
	public function __construct($db) {
		$this->job = new Job($db);
	}

	private function testParserFile($file) {
		$i = pathinfo($file);

		$outname = $i['dirname'] . DIRECTORY_SEPARATOR . $i['filename'] . '.po';
		
		$text = trim(file_get_contents($file));
		$out  = trim(file_get_contents($outname));
		
		$this->job->setDescription($text);	
	
		if ($out != $this->job->getHTMLDescription()) {
			return $this->job->getHTMLDescription() . 
				"\n---------------------------------------------------\n" . 
				$out . "\n";
		}
	
		return true;
	}

	private function printInfo($filename) {
		$p = pathinfo($filename);

		echo str_pad($p['filename'], 60, ' ');
	}
	
	private function test($folder) {
		echo "Parsers...\n";

		$in = glob($folder . '*.p');
		
		foreach($in as $file) {
			$this->printInfo($file);
			
			$res = $this->testParserFile($file);
			
			if (true === $res) {			
				echo "[ OK ]\n";
			} else {
				echo "[ ERROR ]\n" . $res . "\n";
				return false;
			}
		}

		return true;
	}
	
	public static function testFolder($db, $folder) {
		$tester = new Tester($db);
		$tester->test($folder);
	}

}

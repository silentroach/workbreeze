<?php

require(PATH_CLASSES . DIRECTORY_SEPARATOR . 'parser.php');

class Tester {

	private $db;
	private $job;
	
	public function __construct($db) {
		$this->job = new Job($db);
		$this->db = $db;
	}

	private function testCompacterFile($file) {
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
	
	private function testParserFile($parser, $filename) {
		$content = trim($parser->publicAfterRequest(file_get_contents($filename)));
		
		$title_out = trim(file_get_contents(str_replace('.i', '.ot', $filename)));
		$title = trim($parser->parseJobTitle($content));
		
		if ($title != $title_out) {
			$this->error($title);
			return false;
		};
		
		$desc_out = trim(file_get_contents(str_replace('.i', '.od', $filename)));
		$desc  = trim($parser->parseJobDescription($content));
		
		if ($desc != $desc_out) {
			$this->error($desc);
			return false;
		}

		$this->ok();
		return true;
	}

	private function testParsers($folder) {
		echo "\nTesting parsers...\n";

		$s = $this->db->sites->find();

		foreach($s as $site) {
			$file  = $site['script'];
			$class = $site['class'];
			
			require(PATH_CLASSES . DIRECTORY_SEPARATOR . 'parsers' . DIRECTORY_SEPARATOR . $file);
			
			$parser = new $class($this->db);
			
			$fld = $folder . $parser->getSiteFolder() . DIRECTORY_SEPARATOR;
			
			if (!file_exists($fld))
				continue;
			
			echo $fld . "...\n";
			
			$in = glob($fld . '*.i');
			
			foreach($in as $file) {
				$this->printInfo($file);
				
				if (!$this->testParserFile($parser, $file)) {
					die();
				}
			}
		}
	}
	
	private function ok() {
		echo "[ OK ]\n";
	}
	
	private function error($res) {
		echo "[ ERROR ]\n" . $res . "\n";
	}
	
	private function testCompact($folder) {
		echo "\nHTML compacter test...\n";

		$in = glob($folder . '*.p');
		
		foreach($in as $file) {
			$this->printInfo($file);
			
			$res = $this->testCompacterFile($file);
			
			if (true === $res) {			
				$this->ok();
			} else {
				$this->error($res);
				return false;
			}
		}

		return true;
	}
	
	public static function testFolder($db, $folder) {
		$tester = new Tester($db);
		$tester->testParsers($folder);
		$tester->testCompact($folder);
	}

}

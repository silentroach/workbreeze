<?php

if (isset($argc) && $argc > 1 && in_array('br', $argv)) {
	define('BRCONVERT', 1);
}

class Tester {

	private $db;
	
	private $rowcnt;
	
	public function __construct($db) {
		$this->db = $db;
	}

	private function testTextFuncsFile($file) {
		$i = pathinfo($file);

		$outname = $i['dirname'] . DS . $i['filename'] . '.po';
		
		$text = trim(file_get_contents($file));
		$out  = trim(file_get_contents($outname));
		
		$tmp = Text::HTMLPrepare($text);
	
		$check1 = str_replace("\n", '<br />', $tmp);
	
		if ($out != $check1) {
			$out = $check1 . 
				"\n---------------------------------------------------\n" . 
				$out . "\n";

			if (defined('BRCONVERT')) {
				$out = str_replace('<br />', "\n", $out);
			}

			return $out;
		}
		
		return true;
	}

	private function printInfo($filename) {
		$p = pathinfo($filename);

		echo str_pad($p['filename'], 25, ' ');
	}
	
	private function testParserFile($parser, $filename) {
		$content = trim($parser->publicAfterRequest(file_get_contents($filename)));
		
		$title_out = trim(file_get_contents(str_replace('.i', '.ot', $filename)));
		$title = $parser->parseJobTitle($content);
		
		if (!$title) {
			$this->error('failed to parse title');
			return false;
		}
		
		$title = trim($title);
		
		if ($title != $title_out) {
			$this->error($title);
			return false;
		};
		
		$desc_out = trim(file_get_contents(str_replace('.i', '.od', $filename)));
		$desc  = $parser->parseJobDescription($content);
		
		if (!$desc) {
			$this->error('failed to parse description');
			return false;
		}

		// replace local links with real links to parser site (like in parser.php)
		$desc = str_replace('href="/', 'href="' . $parser->getUrl() . '/', $desc);
		
		$desc = trim($desc);
		
		if ($desc != $desc_out) {
			$this->error($desc);
			return false;
		}
		
		$cats_out = trim(file_get_contents(str_replace('.i', '.oc', $filename)));
		$cats = trim($parser->parseJobCategories($content));
		
		if ($cats != $cats_out) {
			$this->error($cats);
			return false;
		}
		
		$money = $parser->parseJobMoney($content);
		
		if ($money) {
			switch ($money[1]) {
				case Job::CUR_RUBLE:
					$cur = 'руб.';
					break;
				case Job::CUR_DOLLAR:
					$cur = '$';
					break;
				case Job::CUR_EURO:
					$cur = 'euro';
					break;
			}
			
			$money = $money[0] . ' ' . $cur;
			
			$money_out = trim(file_get_contents(str_replace('.i', '.om', $filename)));
			
			if ($money != $money_out) {
				$this->error($money);
				return false;
			}
		} else {
			if (file_exists(str_replace('.i', '.om', $filename))) {
				$this->error('money exists in test file');
			}
		}
		
		$this->ok();
		return true;
	}

	private function testParsers($folder) {
		$s = $this->db->sites->find();

		foreach($s as $site) {
			$file  = $site['script'];
			$class = $site['class'];
			
			$parser = new $class($this->db);
			
			$fld = $folder . $parser->getSiteFolder() . DS;
			
			if (!file_exists($fld))
				continue;
				
			$this->begin('Testing parser [' . $parser->getParserName() . ']');
			
			$in = glob($fld . '*.i');
			
			foreach($in as $file) {
				$this->printInfo($file);
				
				if (!$this->testParserFile($parser, $file)) {
					die();
				}
			}
		}
	}
	
	private function printSome($text) {	
		$this->rowcnt++;
		
		echo $text;
		
		if ($this->rowcnt >= 3) {
			echo "\n";
			$this->rowcnt = 0;
		} else {
			echo '   ';
		}
	}

	private function ok() {
		$this->printSome('[ OK ]');
	}
	
	private function error($res) {
		$this->printSome("[ ERROR ]\n" . $res . "\n");
	}

	private function begin($text) {
		echo "\n" . $text . "...\n";
		
		$this->rowcnt = 0;
	}
	
	private function testTextFuncs($folder) {
		$this->begin('Text functions test');

		$in = glob($folder . '*.p');
		
		foreach($in as $file) {
			$this->printInfo($file);
			
			$res = $this->testTextFuncsFile($file);
			
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
		$tester->testTextFuncs($folder);
		
		echo "\n";
	}

}

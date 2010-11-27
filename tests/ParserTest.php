<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

class ParserTest extends PHPUnit_Framework_TestCase {

	private $parsers = array();

	protected function tearDown() {
		unset($this->parsers);
	}

	public static function provider() {
		$result = array();

		foreach (glob(dirname(__FILE__) . DIRECTORY_SEPARATOR . __CLASS__ . DIRECTORY_SEPARATOR . '*') as $path) {
			if (is_dir($path)) {
				$folder = pathinfo($path, PATHINFO_BASENAME);

				foreach (glob($path . DIRECTORY_SEPARATOR . '*.i') as $file) {
					$result[] = array(
						$folder, $file
					);
				}
			}
		}

		return $result;
	}

	private function initParser($folder) {
		if (isset($this->parsers[$folder])) {
			return $this->parsers[$folder];
		}

		$site = Database::sites()->findOne( array(
			'folder' => $folder
		) );

		$this->assertTrue(is_array($site));
		$this->assertArrayHasKey('class', $site);

		$parser = new $site['class']();

		$this->assertInstanceOf('Parser', $parser);
		$this->assertInstanceOf('IParser', $parser);

		$this->parsers[$folder] = $parser;

		return $parser;
	}

	/**
	 * @dataProvider provider
	 */
	public function testParseTitle($folder, $filename) {
		$parser = $this->initParser($folder);

		$resname = pathinfo($filename, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($filename, PATHINFO_FILENAME) . '.ot';

		$content = $parser->publicAfterRequest(file_get_contents($filename));
		$result  = trim(file_get_contents($resname));

		$extracted = $parser->parseJobTitle($content);

		$this->assertEquals($extracted, $result);
	}

	/**
	 * @dataProvider provider
	 */
	public function testParseDescription($folder, $filename) {
		$parser = $this->initParser($folder);

		$resname = pathinfo($filename, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($filename, PATHINFO_FILENAME) . '.od';

		$content = $parser->publicAfterRequest(file_get_contents($filename));
		$result  = trim(file_get_contents($resname));

		$extracted = trim($parser->parseJobDescription($content));

		// local links -> absolute links (see parser.php)
		$extracted = str_replace('href="/', 'href="' . $parser->getUrl() . '/', $extracted);

		$this->assertEquals($extracted, $result);
	}

	/**
	 * @dataProvider provider
	 */
	public function testParseCategories($folder, $filename) {
		$parser = $this->initParser($folder);

		$resname = pathinfo($filename, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($filename, PATHINFO_FILENAME) . '.oc';

		$content = $parser->publicAfterRequest(file_get_contents($filename));
		$result  = trim(file_get_contents($resname));

		$extracted = $parser->parseJobCategories($content);

		$this->assertEquals($extracted, $result);
	}
	
	/**
	 * @dataProvider provider
	 */
	public function testParseMoney($folder, $filename) {
		$parser = $this->initParser($folder);

		$resname = pathinfo($filename, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($filename, PATHINFO_FILENAME) . '.om';

		$content = $parser->publicAfterRequest(file_get_contents($filename));
		$result  = file_exists($resname) ? trim(file_get_contents($resname)) : '';

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
			
			$extracted = $money[0] . ' ' . $cur;
		} else {
			$extracted = '';
		}

		$this->assertEquals($extracted, $result);
	}

}

<?php

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

class BeautifierTest extends PHPUnit_Framework_TestCase {

	public static function provider() {
		$result = array();

		foreach (glob(dirname(__FILE__) . DIRECTORY_SEPARATOR . __CLASS__ . DIRECTORY_SEPARATOR . '*.p') as $filename) {
			$result[] = array($filename);
		}

		return $result;
	}

	/**
	 * @dataProvider provider
	 */
	public function testBeautifier($filename) {
		$outname = $filename . 'o';

		$content = trim(file_get_contents($filename));
		$out     = trim(file_get_contents($outname));

		$conv    = Beautifier::HTMLPrepare($content);

		// more verbose
		$out     = str_replace('<br />', "\n", $out);

		$this->assertEquals($conv, $out);
	}

}

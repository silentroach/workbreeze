<?

require(PATH_CLASSES . 'job.php');

class Tester {

	private $job;
	
	public function __construct() {
		$this->job = new Job();
	}
	
	private function testFile($file) {
		$i = pathinfo($file);
		$outname = $i['dirname'] . DIRECTORY_SEPARATOR . $i['filename'] . '.html';
		
		$text = trim(file_get_contents($file));
		$out  = trim(file_get_contents($outname));
		
		$this->job->setDescription($text);
		
		if ($out != $this->job->getDescription()) {
			return $out . "\n---------------------------------------------------\n" . $this->job->getDescription() . "\n";
		}
	
		return true;
	}
	
	private function test($folder) {
		$in = glob($folder . '*.in');
		
		foreach($in as $file) {
			$p = pathinfo($file);
			echo str_pad($p['filename'], 60, ' ');
			
			$res = $this->testFile($file);
			
			if (true === $res) {			
				echo "[ OK ]\n";
			} else {
				echo "[ ERROR ]\n" . $res . "\n";
				return false;
			}
		}
		
		return true;
	}
	
	public static function testFolder($folder) {
		$tester = new Tester();
		$tester->test($folder);
	}

}

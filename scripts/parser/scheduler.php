<?

require 'parser.php';

class Scheduler {

	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	private function processParser($filename) {
		require($filename);

		$fileInfo = pathinfo($filename);

		$className = 'Parser_' . $fileInfo['filename'];

		$parser = new $className($this->db);

		$name = $parser->getName();

		if (!$name)
			return false;

		echo $name . "\n";

		$lastJobId = 0;

		$parser->processJobs($lastJobId);
	}

	public function process() {
		$parsers = glob('parsers/*.php');

		foreach ($parsers as $parserFile) {
			$this->processParser($parserFile);
		}
	}

}

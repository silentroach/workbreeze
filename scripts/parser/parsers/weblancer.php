<?
class Parser_weblancer extends Parser {

	public function getCode() {
		return 'weblancer';
	}

	public function getName() {
		return 'WebLancer parser 1.0';
	}

	protected function getBaseUrl() {
		return 'http://www.weblancer.net/';
	}
	
	protected function getJobPage($page = 0) {
		$url = $this->getBaseUrl() . 'projects/';

		if ($page > 0) {
			$url .= '?page=' . ($page - 1);
		}

		$page = file_get_contents($url);

		return iconv('cp1251', 'utf-8', $page);
	}

	private function processJobPagePart($part = '') {
		$info = array();

		preg_match('/<a href=\"(\/projects\/(\d+).html)\"(.*?)>(.*?)<\/a>/', $part, $matches);

		if (isset($matches[1])) {
			$info['url'] = $matches[1];
		} else {
			echo "Url not found\n";
			return false;
		}

		if (isset($matches[2])) {
			$info['id'] = $matches[2];
		} else {
			echo "Id not found\n";
			return false;
		}

		if (isset($matches[4])) {
			$info['name'] = $matches[4];
		} else {
			echo "Name not fond\n";
			return false;
		}

		preg_match_all('/<a href=\"\/projects\/\?category_id=(.*?)\">(.*?)<\/a>/', $part, $matches);

		array_shift($matches);

		if (
			!isset($matches[0])
			|| !isset($matches[1])
		) {
			echo "Category matches mismatch\n";
			return false;
		}

		$categories = $this->checkCategories(array_combine($matches[0], $matches[1]));

		if (count($categories) > 0) {
			$info['categories'] = $categories;
		}
		
		return $this->checkJob($info);
	}

	protected function processJobPage($page = '') {
		$i = strpos($page, '<table class="items_list">');

		if (false === $i) {
			$this->log('Job table begin not found');
			return false;
		}

		$page = substr($page, $i, mb_strlen($page) - $i);

		$i = strpos($page, '</table>');

		if (false === $i) {
			$this->log('Job table end not found');
			return false;
		}
	
		$page = substr($page, 1, $i);

		$iterations = 0;

		$i = strpos($page, '</tr>');
		while (
			false !== $i
			&& $iterations < 200
		) {
			if (0 !== $iterations)
				// table title
				if (!$this->processJobPagePart(substr($page, 1, $i)))
					return false;

			$iterations++;

			$page = substr($page, $i + 1, mb_strlen($page) - $i - 1);

			$i = strpos($page, '</tr>');
		}

		return true;
	}

}

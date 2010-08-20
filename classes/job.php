<?php

class Job {

	private $db;

	private $site;
	private $id;
	private $url;
	
	private $stamp;
	
	private $title;
	
	private $description;
	private $description_short = '';
	
	public function __construct($db) {
		$this->db = $db;
		
		$this->stamp = time();
	}
	
	public static function create($db) {
		return new Job($db);
	}
	
	public static function createBySite($db, $site) {
		$job = new Job($db);
		$job->setSite($site);
		return $job;
	}
	
	public static function loadBySiteAndId($db, $site, $id) {
		$job = new Job($db);
		$job->load($site, $id);
		return $job;
	}
	
	public function load($site, $id) {
	
	}
	
	public function insert() {
		$arr = array(
			'stamp'  => $this->getStamp(),
			'site'   => $this->getSite(),
			'id'     => $this->getId(),
			'url'    => $this->getUrl(),
			'title'  => $this->getTitle(),
			'desc'   => $this->getDescription()
		);
		
		if ($this->getShortDescription()) {
			$arr['short'] = $this->getShortDescription();
		}
		
		return $this->db->jobs->insert($arr);
	}
	
	public function getUrl() {
		return $this->url;
	}
	
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = strip_tags($title);
		return $this;
	}
	
	public function getStamp() {
		return $this->stamp;
	}
	
	public function getSite() {
		return $this->site;
	}
	
	public function setSite($id) {
		$this->site = $id;
		return $this;
	}
	
	public function getShortDescription() {
		if ('' != $this->description_short) {
			return $this->description_short;
		}
		
		return false;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($text = '') {
		$text = trim($text);
		
		// free-lance.ru out script
		if (preg_match_all('/a href="\/a.php\?href=(.*?)"/', $text, $matches)) {
			array_shift($matches);
			
			$urls = array_shift($matches);
			
			foreach($urls as $url) {
				$urlnew = urldecode($url);

				$text = str_replace('/a.php?href=' . $url, $urlnew, $text);
			}
		}
		
		// all other links
		if (preg_match_all('/<a(.*?)href="(.*?)"(.*?)>(.*?)<\/a>/', $text, $matches)) {
			$urls = $matches[0];
			
			foreach($urls as $key => $url) {
				$href = $matches[2][$key];
				$val  = $matches[4][$key];
				
				$text = str_replace($url, '<a href="' . $href . '">' . $val . '</a>', $text);
			}
		}
		
		$text = str_replace('•', '- ', $text);
		
		$text = str_replace('&nbsp;', ' ', $text);
		$text = str_replace("\t", '', $text);
		
		while (false !== strpos($text, '  ')) {
			$text = str_replace('  ', ' ', $text);
		}
		
		$text = str_replace(
			array('<br />', '<br>', '<br/>'),
			"\n",
			$text
		);
		
		$text = str_replace(
			array('&nbsp;', '/>' , ' >', '> ', ' </'),
			array(' '     , ' />', '>' , '>' ,  '</'),
			$text
		);
		
		$text = str_replace(array(" \n", "\n "), "\n", $text);
		
		while (false !== strpos($text, "\n\n\n")) {
			$text = str_replace("\n\n\n", "\n\n", $text);
		}
		
		$text = strip_tags($text, '<a>');
		
		$text = str_replace(array("\r\n", "\r", "\n"), '<br />', $text);
		$text = str_replace(array(' . ', ' , '), array('. ', ', '), $text);
	
		$text = trim($text);
		
		while ('<br />' === mb_substr($text, strlen($text) - 6, 6)) {
			$text = mb_substr($text, 0, strlen($text) - 6);
		}
		
		while ('<br />' === mb_substr($text, 0, 6)) {
			$text = mb_substr($text, 6, strlen($text) - 6);
		}
		
		$this->description = trim($text);
		
		if (preg_match('/([^ \n\r]+[ \n\r]+){20}/s', $text, $match))
			$this->description_short = str_replace('<br /><br />', '<br />', $match[0]) . '...';
		
		return $this;
	}

}

<?php

class Parser_freelancer_com extends Parser implements IParser {

	public function getSiteCode() {
		return 3;
	}
	
	public function getSiteName() {
		return 'Freelancer';
	}
	
	public function getSiteFolder() {
		return 'freelancer_com';
	}
	
	public function getParserName() {
		return 'Freelancer parser 0.1';
	}
	
	public function getUrl() {
		return 'http://www.freelancer.com';
	}
	
	public function isProxyFied() {
		return false;
	}
	
	protected function afterRequest($data) {
		return iconv('iso-8859-1', 'utf-8', $data);
	}
	
	public function processJobList() {
		$res = $this->getRequest('http://www.freelancer.com/projects/all.php');

		if (!$res)
			return false;

/*
<a href="../projects/Graphic-Design-Logo-Design/logo-design-needed-Sulais.html" class="">A logo design needed #6 (Sulais)</a>
*/

		preg_match_all('/<a href="..\/projects\/(.*?)"/', $res, $matches);
		
		array_shift($matches);
			
		if (0 === count($matches))
			return;
			
		$matches = array_shift($matches);

		foreach($matches as $match) {
			if (!preg_match('/^(\d+).html/', $match, $matches)) {
				$this->queueJobLink(md5($match), "http://www.freelancer.com/projects/" . $match);
			}
		}
	}
	
	public function processJob($id, $url) {
		$res = $this->getRequest($url);
	
		if (!$res)
			return false;
			
		if (404 === $res)
			// drop queued jobs that are not found
			return true;
	
/*
<p>
	<a href="../../projects/PHP-Website-Design/PHP-MYSQL-Database-Coder-Designer.html">
		<strong>
			PHP/MYSQL/Database Coder Designer Web Portal Project
		</strong>
	</a> 
	is project number 774579 <br />
	posted at <a href="../..">Freelancer.com</a>. 
	<a href="http://www.freelancer.com/buyers/create.php">Click here</a> 
	to post your own project.
</p> 
*/
		if (
			!preg_match('/<h2(.*?)>(.*?)<\/h2>/is', $res, $matches)
			|| 3 != count($matches)
		) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract title' 
			));
			return true;
		}
		
		$title = trim(str_replace('&nbsp;', '', strip_tags(array_pop($matches))));

		if ('' === $title) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract title' 
			));
			return true;
		}
		
		$i = strpos($res, '<h3>Description</h3>');
		if (false === $i) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t found description' 
			));
			return true;
		}
		
		$desc = mb_substr($res, $i, mb_strlen($res) - $i);

		$i = strpos($desc, '<td>');
		if (false === $i) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t found description' 
			));
			return true;
		}
		
		$desc = mb_substr($desc, $i + 4, mb_strlen($desc) - $i - 4);
		
		$i = strpos($desc, '</td>');
		if (false === $i) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t found description' 
			));
			return true;
		}
		
		$desc = mb_substr($desc, 0, $i);
		
		$job = $this->newJob();
		$job->
			setId($id)->
			setUrl($url)->
			setTitle($title)->
			setDescription($desc);
				
		$this->addJob($job);

		return true;
	}
	
}




















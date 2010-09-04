<?php

class Parser_vworker_com extends Parser implements IParser {

	public function getSiteCode() {
		return 5;
	}
	
	public function getSiteName() {
		return 'vworker.com';
	}
	
	public function getSiteFolder() {
		return 'vworker_com';
	}
	
	public function getParserName() {
		return 'VWorker parser 0.1';
	}
	
	public function getUrl() {
		return 'http://www.vworker.com';
	}
	
	public function getLang() {
		return Language::ENGLISH;
	}
	
	public function isProxyFied() {
		return false;
	}
	
	protected function afterRequest($data) {
		return iconv('iso-8859-1', 'utf-8', $data);
	}	
	
	public function processJobList() {
		$res = $this->getRequest('http://www.vworker.com/RentACoder/misc/BidRequests/ShowBidRequests.asp?intFirstRecordOnPage=1&intLastRecordOnPage=10&txtMaxNumberOfEntriesPerPage=10&optSortTitle=2&blnAuthorSearch=False&optBidRequestPhase=2&lngBidRequestListType=3&lngSortColumn=-6&lngBidRequestCategoryId=-1&optBiddingExpiration=1&cmdGoToPage=1');

		if (!$res)
			return false;

/*
<a href="/RentACoder/misc/BidRequests/ShowBidRequest.asp?lngBidRequestId=1491325"> 
	<b>Word Press Theme Install</b>
</a> 
*/

		preg_match_all('/(\/RentACoder\/misc\/BidRequests\/ShowBidRequest.asp\?lngBidRequestId=(\d+))"/', $res, $matches);
		
		array_shift($matches);
		
		if (2 != count($matches))
			return;
		
		$matches = array_combine($matches[1], $matches[0]);

		foreach($matches as $id => $match) {
			$this->queueJobLink($id, 'http://www.vworker.com' . $match);
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
<div class="KonaBody">
	The Chordosome is an app that runs in a browser.  JavaScript might be best for it, but you may use
	the open-source technology of your choice.  (Please specify in your bid which one you choose.)<br /> 
	<br /> 
	The Chordosome is a music-themed web app.  It reads,  from a file or a URL, a description of a song, consisting 
	of lyrics marked up with a description of the accompanying chords.  It counts off the beats, displaying the 
	current chord and section of lyrics as it goes.  The user can pause and restart, and reposition within the
	song.<br /> 
	<br /> 
	The output of the Chordosome is purely visual; it produces no audio output.   <br /> 
	<br /> 
	<br /> 
</span><br></font> 
*/
		if (
			!preg_match('/<div class="KonaBody">(.*?)<\/span>/is', $res, $matches)
			|| 2 != count($matches)
		) {
			$this->log(array(
				'url'  => $url, 
				'msg'  => 'can\'t extract description' 
			));
			return true;
		}
		
		$desc = $matches[1];
		
		
		if (
			!preg_match('/<h1>(.*?)<br>/is', $res, $matches)
			|| 2 != count($matches)
		) {
			$this->log(array(
				'url' => $url,
				'msg' => 'can\'t extract title'
			));
			return true;
		}
				
		$title = $matches[1];
		
		//
		
		if (
			!preg_match('/Categories:(.*?)<font size=1>(.*?)<br>(.*?)<\/font>/is', $res, $matches)
			|| 4 != count($matches)
		) {
			$this->log(array(
				'url' => $url,
				'msg' => 'can\'t extract categories'			
			));
			return true;
		}
		
		$cats = array_pop($matches);
		
		$job = $this->newJob();
		$job->
			setId($id)->
			setUrl($url)->
			setTitle($title)->
			setDescription($desc);
		
		if ('' !== $cats) {
			$job->setCategoriesByText($cats);
		}
				
		$this->addJob($job);

		return true;
	}
	
}




















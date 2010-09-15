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
		return 'VWorker parser 1.0';
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
	
	public function parseJobTitle($content) {
		if (
			!preg_match('/<h1>(.*?)<br>/iu', $content, $matches)
			|| 2 != count($matches)
		) {
			return false;
		}
				
		return $matches[1];
	}
	
	public function parseJobDescription($content) {
		if (
			preg_match('/<div class="KonaBody">(.*?)<\/span>/is', $content, $matches)
			&& 2 == count($matches)
		) {
			$found = $matches[1];
		} else		
		if (
			preg_match('/<div class="KonaBody">(.*?)Requirements Interview Answers/is', $content, $matches)
			&& 2 == count($matches)
		) {
			$found = $matches[1];
		}

		if (isset($found)) {
			return str_replace(array("\r", "\n"), '', $found);
		} else
			return false;
	}
	
	public function parseJobCategories($content) {
		if (
			!preg_match('/Categories:(.*?)<font size=1>(.*?)<br>(.*?)<\/font>/is', $content, $matches)
			|| 4 != count($matches)
		) {
			return false;
		}
		
		return array_pop($matches);
	}
	
	public function parseJobMoney($content) {
		if (
			preg_match('/Max Accepted Bid:(.*?)size="1">(.*?)\(<a/siu', $content, $matches)
			&& 3 == count($matches)
		) {
			$val = trim(str_replace('&nbsp;', '', array_pop($matches)));
			
			if (false !== mb_strpos($val, '$', 0, 'UTF-8')) {
				$currency = Job::CUR_DOLLAR;
				
				$val = floatval(trim(preg_replace('/\$/siu', '', $val)));
			}
			
			if (
				isset($currency)
				&& $val != 0
			) {
				return array(
					$val,
					$currency
				);
			}
		}
		
		return false;
	}
		
}

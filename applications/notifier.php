<?php

$root = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;

require $root . 'bootstrap.php';

class WorkbreezeNotifier extends AppInstance {

	private $lastcheck;
	private $laststamp;
	private $cache;

	public function init() {
		// fetching the last offer stamp
		$cursor = Database::jobs()->find();
		$cursor->sort(array('stamp' => -1))->limit(1);
		
		while ($item = $cursor->getNext()) {
			$this->laststamp = $item['stamp'];
		}

		// initial time of last check is now
		$this->lastcheck = time();

		// initialized. let's say about it
		Daemon::log('Workbreeze notifier up');		
	}

	public function onReady() {
		$appInstance = $this;

		if ($this->WS = Daemon::$appResolver->getInstanceByAppName('WebSocketServer')) {
			$this->WS->addRoute('WorkbreezeNotifier',
				function ($client) use ($appInstance) {
					return new WorkbreezeWebSocketSession($client, $appInstance);
				}
			);
		}
	}

	public function getLastStamp() {
		return $this->laststamp;
	}

	// -----------------------------------------------------
	// main part
	// -----------------------------------------------------

	private function checkOffers() {
		$now = time();

		// have to wait at least 5 seconds after previous check
		if ($now - $this->lastcheck < 5) {
			return;
		}

		$this->lastcheck = time();

		if (0 !== sizeof($this->cache)) {
			// lets clean a cache
			foreach($this->cache as $stamp => $item) {
				// 30 seconds for spare
				if ($now - $stamp > 30) {
					unset($this->cache[$stamp]);
				}
			}
		}

		// checking new offers
		$cursor = Database::jobs()->find(array(
			'stamp' => array(
				'$gt' => $this->laststamp
			)
		))->sort(array('stamp' => 1));
		
		while ($item = $cursor->getNext()) {
			$this->laststamp = $item['stamp'];
			$this->cache[$this->laststamp] = $item;
		}
	}

	public function newOffers($stamp) {
		$this->checkOffers();

		if ($this->laststamp === $stamp) {
			return false;
		}

		$result = array();

		foreach($this->cache as $cstamp => $citem) {
			if ($cstamp > $stamp) {
				$result[] = $citem;
			}
		}

		return $result;
	}

}

class WorkbreezeWebSocketSession extends WebSocketRoute {

	private $requests = array();

	/**
	 * Called when new frame received.
	 * @param string Frame's contents.
	 * @param integer Frame's type.
	 * @return void
	 */
	public function onFrame($data, $type) {
		$o = json_decode($data, true);

		if (
			!isset($o['cmd'])
			|| !is_string($o['cmd'])
		) {
			return;
		}

		if ('subscribe' === $o['cmd']) {
			$r = new stdClass;
			$r->attrs = $o['attrs'];
			$req = new WorkbreezeNotifierRequest($this->appInstance, $this->appInstance, $r);
			$req->sessions[$this->client->connId] = true;
			$this->requests[] = $req->queueId;
		}
	}

	public function onFinish() {
		while ($id = array_pop($this->requests)) {
			if (!isset(Daemon::$process->queue[$id])) {
				continue;
			}

			unset(Daemon::$process->queue[$id]->sessions[$this->client->connId]);
		}
	}

}

class WorkbreezeNotifierRequest extends Request {

	public $stream;
	public $buf = '';
	public $sessions = array();

	private $laststamp;

	// -----------------------------
	// Filter arrays
	// -----------------------------
	private $fcats  = false;
	private $fsites = false;
	private $fkeys  = false;

	public function init() {
		// getting last stamp from application instance
		$this->laststamp = $this->appInstance->getLastStamp();

		// TODO refactor

		if (isset($this->attrs['filter_cats'])) {
			$this->fcats = explode(',', $this->attrs['filter_cats']);

			if (0 === sizeof($this->fcats)) {
				$this->fcats = false;
			}
		}

		if (isset($this->attrs['filter_sites'])) {
			$this->fsites = explode(',', $this->attrs['filter_sites']);

			if (0 === sizeof($this->fsites)) {
				$this->fsites = false;
			}
		}

		if (isset($this->attrs['filter_keys'])) {
			// query for sphinx

			if (0 === sizeof($this->fkeys)) {
				$this->fkeys = false;
			}
		}
	}

	private function checkOffer($offer) {
		if (
			$this->fsites
			&& !in_array($offer['site'], $this->fsites)
		) {
			return false;
		}

		if (
			$this->fcats
			&& isset($offer['cats'])
			&& 0 === sizeof(array_intersect($this->fcats, $offer['cats']))
		) {
			return false;
		}

		if (
			$this->fkeys
			&& isset($offer['stem'])
			&& 0 === sizeof(array_intersect($this->fkeys, $offer['stem']))
		) {
			return false;
		}

		return true;
	}

	/**
	 * Called when request iterated.
	 * @return integer Status.
	 */
	public function run() {
		$items = $this->appInstance->newOffers($this->laststamp);

		if ($items) {
			$offers = array();

			while ($item = array_shift($items)) {
				$this->laststamp = $item['stamp'];

				if ($this->checkOffer($item)) {	
					$offers[] = Job::prepareJSON($item);
				}
			}
		
			if (sizeof($offers) > 0) {
				$joffers = JSON::encode(array(
					'j' => array_reverse($offers)
				));
		
				foreach ($this->sessions as $sessId => $v) {
					$this->appInstance->WS->sessions[$sessId]->sendFrame($joffers);
				}
			}
		}

		$this->sleep(5); // sleeping for 5 seconds
	}

}

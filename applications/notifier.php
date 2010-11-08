<?php

$root = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;

require $root . 'bootstrap.php';

class WorkbreezeNotifier extends AppInstance {

	public function init() {
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

	private $database;	
	private $laststamp;

	// -----------------------------
	// Filter arrays
	// -----------------------------
	private $fcats  = false;
	private $fsites = false;
	private $fkeys  = false;

	public function init() {
		$connection = new Mongo();
		$this->database = $connection->selectDB(DB);

		$cursor = $this->database->jobs->find();
		$cursor->sort(array('stamp' => -1))->limit(1);
		
		while ($item = $cursor->getNext()) {
			$this->laststamp = $item['stamp'];
		}

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
			$this->fkeys = Text::Stem(Text::ExtractWords($this->attrs['filter_keys']));

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
		$offers = array();
		
		$cursor = $this->database->jobs->find(array(
			'stamp' => array(
				'$gt' => $this->laststamp
			)
		))->sort(array('stamp' => 1));
		
		while ($item = $cursor->getNext()) {
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

		$this->sleep(5); // sleeping for 5 seconds
	}

}

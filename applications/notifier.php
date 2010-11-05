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
		//Daemon::log($data);
	
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

	public function init() {
		$connection = new Mongo();
		$this->database = $connection->selectDB(DB);

		$cursor = $this->database->jobs->find();
		$cursor->sort(array('stamp' => -1))->limit(1);
		
		while ($item = $cursor->getNext()) {
			$this->laststamp = $item['stamp'];
		}
	}

	private function checkOffer($offer) {
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
		))->sort(array('stamp' => -1));
		
		while ($item = $cursor->getNext()) {
			$this->laststamp = $item['stamp'];
			
			if ($this->checkOffer($item)) {
				$offers[] = Job::prepareJSON($item);
			}
		}
		
		if (sizeof($offers) > 0) {
			$joffers = JSON::encode(array(
				'j' => $offers
			));
		
			foreach ($this->sessions as $sessId => $v) {
				$this->appInstance->WS->sessions[$sessId]->sendFrame($joffers);
			}
		}

		$this->sleep(5); // sleeping for 5 seconds
	}

}

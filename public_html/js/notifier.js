 /* <debug> */
if ('WebSocket' in window) {
	console.info('WebSocket exists');
} else {
	console.warn('WebSocket is not available');
}
/* </debug> */

/**
 * @constructor
 * @this {Workbreeze.NotifierParams}
 */
Workbreeze.NotifierParams = function() {
	var self = this;

	/**
	 * @type {Object}
	 */
	self.params = {};

	/**
	 * @type {Object}
	 */
	self.ajaxOnly = {};
}

/**
 * Object to notify script with new offers
 * @constructor
 * @this {Workbreeze.Notifier}
 */
Workbreeze.Notifier = function(s) {
	var self = this;

	/**
	 * Options object
	 * @type {Object}
	 */
	var options = $.extend({
		/**
		 * @type {number} 
		 */
		updateTime: 10000,
		
		/** 
		 * @type {Workbreeze.NotifierParams} 
		 */
		params: new Workbreeze.NotifierParams(),
		
		/**
		 * @type {function(Object)} 
		 */
		onData: function(data) { }
	}, s);
	
	var started = false;
	var ajaxTimer = null;
	var ws = null;

	var handleParamsChanged = function() {
		console.info('params changed');
	
		self.stop();
		self.start();
	};

	/**
	 * Set the parameters
	 * @param {Workbreeze.NotifierParams} params Parameters
	 */
	self.setParams = function(params) {	
		var changed = false;

		if (JSON.stringify(options.params.params) != JSON.stringify(params.param)) {
			options.params.params = params.params;
			changed = true;
		}
		
		options.params.ajaxOnly = params.ajaxOnly;

		if (changed) {
			handleParamsChanged();
		} else 
		if (!started) {
			self.start();
		}
	};

	// -----------------------------------------------------
	// Initialization
	// -----------------------------------------------------
	
	/**
	 * Initialize the WebSocket notification
	 */
	var initWebSocket = function() {
		/* <debug> */
		console.info('initializing WebSocket notifier');
		/* </debug> */

		var createWebSocket = function() {
			if (null !== ws) {
				ws.close();
			}
		
			ws = new WebSocket('ws://' + document.location.host + ':8047/WorkbreezeNotifier');

			ws.onmessage = function(e) {				
				try {
					var obj = $.parseJSON(e.data);
					
					/* <debug> */
					console.dir(obj);
					/* </debug> */
				
					options.onData(obj);
				} catch (error) { }
			}

			ws.onclose = function() {
				/* <debug> */
				console.info('websocket connection is closed')
				/* </debug> */

				setTimeout(createWebSocket, 5000);
			}

			ws.onopen = function() {
				var cmd = {
					'cmd'   : 'subscribe',
					'attrs' : options.params.params
				};

				/* <debug> */
				console.info('websocket connection is opened');
				console.dir(cmd);
				/* </debug> */

				ws.send(JSON.stringify(cmd));
			}
		}

		createWebSocket();

		return true;
	};

	/**
	 * Initialize notifications by ajax
	 */
	var initAjax = function() {
		/* <debug> */
		console.info('initializing ajax notifier');
		/* </debug> */

		var setupAjax = function(updateTime) {
			if (null !== ajaxTimer) {
				clearTimeout(ajaxTimer);
			}
		
			ajaxTimer = setTimeout(function() {
				Workbreeze.Ajax( {
					data: $.extend(options.params.params, options.params.ajaxOnly),
					success: function(data) {
						if (null !== data) {
							options.onData(data);
						}
						
						setupAjax(options.updateTime);
					},
					error: function(request, status, error) {
						// wait a little when failed and return again
						setupAjax(options.updateTime * 2);
					}
				} );
			}, updateTime);
		}
		
		setupAjax(options.updateTime);
		
		return true;
	}
	
	// -----------------------------------------------------
	// Public functions
	// -----------------------------------------------------	
	
	self.start = function() {
		if (started) {
			return;
		}
	
		if (
			!('WebSocket' in window) ||
			!initWebSocket()
		) {
			initAjax();
		};
		
		started = true;
	}
	
	self.stop = function() {
		started = false;
	
		if (null !== ajaxTimer) {
			clearTimeout(ajaxTimer);
		}
		
		if (null !== ws) {
			ws.close();
		}
	}
};

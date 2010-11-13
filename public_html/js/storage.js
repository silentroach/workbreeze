/* <debug> */
if ('localStorage' in window && window['localStorage'] !== null) {
	console.info('localStorage enabled');
} else {
	console.warn('localStorage is not available');
}
/* </debug> */

/**
 * Storage object
 * @constructor
 * @this {Workbreeze.Storage}
 */
Workbreeze.Storage = function() {
	var self = this;

	/**
	 * Cached items
	 * @type {Array}
	 */
	var cache = [];

	/**
	 * Is localStorage enabled in this browser?
	 * @type {boolean}
	 * @private
	 */
	var enabled = 'localStorage' in window && window['localStorage'] !== null;

	/**
	 * Get object from storage
	 * @param {!string} itemName Storage item name.
	 * @return {(Object|boolean)} Storage item value.
	 */
	self.get = function(itemName) {
		if (!enabled) {
			return false;
		}

		if (!(itemName in cache)) {
			cache[itemName] = $.parseJSON(localStorage.getItem(itemName)) || false;
		}

		return cache[itemName];
	};

	/**
	 * Store object
	 * @param {!string} itemName Storage item name.
	 * @param {(Object|Array)} object Object to store.
	 * @param {?number} version Version of object.
	 */
	self.set = function(itemName, object, version) {
		if (!enabled) {
			return;
		}

		var str = JSON.stringify((undefined === version ?
															object : [version, object]));

		localStorage.setItem(itemName, str);
	};

	/**
	 * Get version of storage item
	 * @param {!string} itemName Storage item name.
	 * @return {number} Storage item version.
	 */
	self.getVersion = function(itemName) {
		if (!enabled) {
			return 0;
		}

		var item = self.get(itemName);

		if (!item || item.length != 2) {
			return 0;
		}

		return Math.floor(item[0]);
	};
};

/* <debug> */
if ('undefined' != typeof(localStorage)) {
	console.info('local storage enabled');
} else {
	console.warn('local storage not available');
}
/* </debug> */

var workbreeze = workbreeze || [];

/**
 * Storage object
 * @constructor
 */
workbreeze.storage = function() {
	var self = this;

	/**
	 * Is Local Storage enabled in this browser?
	 * @type {Boolean}
	 * @private
	 */
	var enabled = ('localStorage' in window) && window['localStorage'] !== null;
	
	/**
	 * Get object from storage
	 * @param {!string} itemName Storage item name
	 * @return {(Object|boolean)}
	 */
	self.get = function(itemName) {
		if (!enabled)
			return false;

		try {
			return JSON.parse(localStorage.getItem(itemName));
		} catch (err) {
			return false;
		}
	};	
	
	/**
	 * Store object
	 * @param {!string} itemName Storage item name
	 * @param {(Object|Array)} object Object to store
	 * @param {?number} version Version of object
	 */
	self.set = function(itemName, object, version) {
		if (!enabled)
			return;

		var str = JSON.stringify((undefined === version ? object : [version, object]));

		localStorage.setItem(itemName, str);	
	};

	/**
	 * Get version of storage item
	 * @param {!string} itemName Storage item name
	 * @return {number}
	 */
	self.getVersion = function(itemName) {
		if (!enabled)
			return 0;
		
		var item = self.get(itemName);

		if (
			!item
			|| item.length != 2
		) {
			return 0;
		}

		return Math.floor(item[0]);
	};	
};

/**
 * @type {workbreeze.storage}
 */
var storage = new workbreeze.storage();

/* <debug> */
if ('localStorage' in window) {
	console.info('local storage enabled');
} else {
	console.warn('local storage not available');
}
/* </debug> */

/**
 * Storage object
 * @constructor
 * @this {workbreeze.storage}
 */
workbreeze.storage = function() {
	var self = this;
	
	/**
	 * Cached items
	 * @type {Array}
	 */
	var cache = [];

	/**
	 * Is localStorage enabled in this browser?
	 * @type {Boolean}
	 * @private
	 */
	var enabled = ('localStorage' in window);
	
	/**
	 * Get object from storage
	 * @param {!string} itemName Storage item name
	 * @return {(Object|boolean)}
	 */
	self.get = function(itemName) {
		if (!enabled)
			return false;
			
		if (!(itemName in cache)) {
			cache[itemName] = $.parseJSON(localStorage.getItem(itemName)) || false;
		}
			
		return cache[itemName];
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

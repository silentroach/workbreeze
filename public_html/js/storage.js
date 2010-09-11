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
	/**
	 * Is Local Storage enabled in this browser?
	 * @type {Boolean}
	 * @private
	 */
	this.enabled = ('localStorage' in window) && window['localStorage'] !== null;
};

/**
 * Get object from storage
 * @param {!string} itemName Storage item name
 * @return {(Object|boolean)}
 */
workbreeze.storage.prototype.get = function(itemName) {
	if (!this.enabled)
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
workbreeze.storage.prototype.set = function(itemName, object, version) {
	if (!this.enabled)
		return;

	var str = JSON.stringify((undefined === version ? object : [version, object]));

	localStorage.setItem(itemName, str);	
};

/**
 * Get version of storage item
 * @param {!string} itemName Storage item name
 * @return {number}
 */
workbreeze.storage.prototype.getVersion = function(itemName) {
	if (!this.enabled)
		return 0;
	
	var item = this.get(itemName);

	if (
		!item
		|| item.length != 2
	) {
		return 0;
	}

	return Math.floor(item[0]);
};

/**
 * @type {workbreeze.storage}
 */
var storage = new workbreeze.storage();

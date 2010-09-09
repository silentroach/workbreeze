var is_ls = false;

/** @type {Array} **/ var ls_items = [];

function finit() {
	is_ls = ('undefined' != typeof(localStorage));

/* <debug> */
	if (is_ls) {
		console.info('local storage enabled');
	} else {
		console.warn('local storage not available');
	}
/* </debug> */
}

/**
 * Check leading zero in single char int
 * @param {!number} i Number
 * @return {string}
 */
function checkTimeVal(i) {
        if (i < 10) {
                i = "0" + i;
        }

        return i;
}

/**
 * Get storage item version
 * @param {!string} itemName Name of localStorage object
 * @return {number}
 */
function getLocalStorageItemVersion(itemName) {
	var tmp = getLocalStorageItem(itemName);
	
	if (
		!tmp
		|| tmp.length != 2
	)
		return 0;
	
	ls_items[itemName] = tmp;
	
	return Math.floor(tmp[0]);
}

/**
 * Get storage item
 * @param {!string} itemName Name of localStorage object
 * @return {Object|Boolean}
 */
function getLocalStorageItem(itemName, skipcache) {
	if (!is_ls)
		return false;

	if (!(itemName in ls_items)) {
		try {
			ls_items[itemName] = JSON.parse(localStorage.getItem(itemName));
		} catch (err) {
			ls_items[itemName] = false;
		}
	}
	
	return ls_items[itemName];
}

/**
 * Add item to localStorage
 * @param {!string} itemName Name of localStorage object
 * @param {!number} version Version of object
 * @param {!Object} object Object to store
 */
function addLocalStorageItem(itemName, version, object) {
	if (!is_ls)
		return;
		
	localStorage.setItem(itemName, JSON.stringify([version, object]));
}

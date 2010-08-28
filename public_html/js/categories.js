/** @type {Array} **/ var cats = [];

/**
 * Get local storage categories version
 * @return {number} Categories object version
 */
function getCatsVersion() {
	var cver = getLocalStorageItemVersion(options.elementCats);
	
	if (cver) {
		cats = getLocalStorageItem(options.elementCats);
	}

	return cver;
}

/**
 * Load categories
 * @param {!Object} val Load category objects from ajax request
 */
function loadCats(val) {
	var tmp = val['vl'];
	
	for (var i = 0; i < tmp.length; i++) {
		var cat = tmp[i];
		
		cats[cat['i']] = cat['l'];
	}
	
	addLocalStorageItem(options.elementCats, val['v'], cats);
}

/**
 * Init cats info
 */
function initCats() {

}

/** @type {Array} **/ var cats = [];

/**
 * Get local storage categories version
 * @return {number} Categories object version
 */
function getCatsVersion() {
	if (!is_ls)
		return 0;
		
	try {
		var tmp = JSON.parse(localStorage.getItem('cats'));
	} catch (err) {
		return 0;
	}
	
	if (!tmp)
		return 0;

	if (
		'undefined' == typeof(tmp)
		|| 'undefined' == typeof(tmp['v'])
	)
		return 0;
		
	cats = tmp['vl'];

	return Math.floor(tmp['v']);
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
	
	if (is_ls) {
		localStorage.setItem('cats', JSON.stringify({'v': val['v'], 'vl': cats}));
	}
}

/**
 * Init cats info
 */
function initCats() {

}

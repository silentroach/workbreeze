/** @type {Array} **/ var cats = [];

/**
 * Get local storage categories version
 * @return {number} Categories object version
 */
function getCatsVersion() {
	var cver = getLocalStorageItemVersion(options.elementCats);
	
	if (cver > 0) {
		var tmp = getLocalStorageItem(options.elementCats);

		cats = tmp[1];
	}

	return cver;
}

/**
 * Load categories
 * @param {!Object} val Load category objects from ajax request
 */
function loadCats(val) {
	var tmp = val['vl'];
	
	for (var i in tmp) {
		var cat = tmp[i];

		item = [];
		item[0] = cat['i'];  // id
		item[1] = cat['l'];  // lang val
		
		cats[item[0]] = item; 
	}
	
	addLocalStorageItem(options.elementCats, val['v'], cats);
}

/**
 * Init cats info
 */
function initCats() {
	var cplace = $('#categories');
	
	for (var i in cats) {
		var cat = cats[i];
		selcats.push(i);

		var sp = $('<span></span>')
			.html(langVal(cat[1]));

		var li = $('<li></li>')
			.addClass('checkable checked')
			.attr( {
				'id'   : 'c' + i,
				'cat' : i
			} )
			.click(function() {
				$(this).toggleClass('checked');
				handleFilter();
			} );

		li.appendTo(cplace);
		sp.appendTo(li);
	}
}

/** @type {Array} **/ var cats = [];

/**
 * Get local storage categories version
 * @return {number} Categories object version
 */
function getCatsVersion() {
	var cver = getLocalStorageItemVersion(options.elementCats);
	
	if (cver > 0) {
		var tmp = getLocalStorageItem(options.elementCats);

                if ('undefined' != typeof(tmp['vl'])) {
                        cats = tmp['vl'];
                } else {
                        return 0;
                }
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

		item = {
			id: cat['i'],
			name: cat['l']
		}
		
		cats.push(item);
	}
	
	addLocalStorageItem(options.elementCats, val['v'], cats);
}

/**
 * Init cats info
 */
function initCats() {
	var cplace = $('#categories');
	
	for (var i = 0; i < cats.length; i++) {
		var cat = cats[i];

		selcats.push(i);

		var sp = $('<span></span>')
			.html(langVal(cat.name));

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

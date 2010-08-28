/** @type {Array} **/ var sites = [];

/**
 * Get local storage sites version
 * @return {number} Site object version
 */
function getSitesVersion() {
	var sver = getLocalStorageItemVersion(options.elementSites);
	
	if (sver > 0) {
		var tmp = getLocalStorageItem(options.elementSites);

		if ('undefined' != typeof(tmp['vl'])) {
			sites = tmp['vl'];
		} else {
			return 0;
		}
	}

	return sver;
}

/**
 * Load sites
 * @param {!Object} val Load site objects from ajax request
 */
function loadSites(val) {
	var tmp = val['vl'];
	
	for (var i = 0; i < tmp.length; i++) {
		var site = tmp[i];
		
		var item = {
			folder: site['f'],
			name:   site['n'],
			url:    site['u']
		}
		
		sites[site['i']] = item;
	}
	
	addLocalStorageItem(options.elementSites, val['v'], sites);
}

/**
 * Init sites info
 */
function initSites() {
	var splace = $('#sites');

	for (var i = 0; i < sites.length; i++) {				
		var site = sites[i];
		
		selsites.push(i);

		var sp  = $('<span></span>')
			.addClass('sico sico_' + site.folder)
			.html(site.name);
	
		var li = $('<li></li>')
			.addClass('checkable checked')
			.attr( {
				'id'   : 'c' + i,
				'site' : i
			} )
			.click(function() {
				$(this).toggleClass('checked');
				handleFilter();
			} );
		
		li.appendTo(splace);
		sp.appendTo(li);
	}
}

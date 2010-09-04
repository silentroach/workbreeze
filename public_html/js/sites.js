/** @type {Array} **/ var sites = [];

/**
 * Get local storage sites version
 * @return {number} Site object version
 */
function getSitesVersion() {
	var sver = getLocalStorageItemVersion(options.elementSites);
	
	if (sver > 0) {
		var tmp = getLocalStorageItem(options.elementSites);

		sites = tmp[1];
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
		
		var item = [];
		item[0] = site['i'];  // id
		item[1] = site['f'];  // folder
		item[2] = site['n'];  // name
		item[3] = site['u'];  // url
		
		sites[item[0]] = item;
	}
	
	addLocalStorageItem(options.elementSites, val['v'], sites);
}

/**
 * Init sites info
 */
function initSites() {
	var splace = $('#sites');

	nsites = sites;

	nsites.sort(function(a, b) {
		return (b[2] < a[2]) ? 1 : -1;
	});

	for (var i in nsites) {
		var site = nsites[i];
		selsites.push(i);

		var sp  = $('<span></span>')
			.addClass('sico sico_' + site[0])
			.html(site[2]);
	
		var li = $('<li></li>')
			.addClass('checkable checked')
			.attr( {
				'id'   : 'c' + site[0],
				'site' : site[0]
			} )
			.click(function() {
				$(this).toggleClass('checked');
				handleFilter();
			} );
		
		li.appendTo(splace);
		sp.appendTo(li);
	}
}

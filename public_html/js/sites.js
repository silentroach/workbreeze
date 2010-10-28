/** @type {Array} **/  var sites = [];

/**
 * Get local storage sites version
 * @return {number} Site object version
 */
function getSitesVersion() {
	var sver = storage.getVersion(options.elementSites);
	
	if (sver > 0) {
		var tmp = storage.get(options.elementSites);

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

	$(tmp).each( function() {	
		var site = this;
		
		var item = [];
		item[0] = site['i'];  // id
		item[1] = site['f'];  // folder
		item[2] = site['n'];  // name
		item[3] = site['u'];  // url
		
		sites[item[0]] = item;
	} );
	
	storage.set(options.elementSites, sites, val['v']);
}

/**
 * Init sites info
 */
function initSites() {
	var splace = $('#sites');
	var sempty = settings.selsites.length == 0;

	$(sites).each( function() {
		var site = this;

		var sp  = $('<span></span>')
			.addClass(options.siteIconPrefix)
			.addClass(options.siteIconPrefix + '_' + site[0])
			.html(site[2]);

		var li = $('<li></li>')
			.addClass('checkable')
			.attr( {
				'id'   : 'c' + site[0],
				'site' : site[0]
			} )
			.click(function() {
				$(this).toggleClass('checked');
				handleFilter();
			} );

		if (
			sempty
			|| settings.selsites.indexOf(site[0]) >= 0
		) {
			li.addClass('checked');
		}

		if (sempty) {
			settings.addSite(site[0]);
		}
		
		li.appendTo(splace);
		sp.appendTo(li);
	} );
}

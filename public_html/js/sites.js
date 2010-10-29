/**
 * Sites object
 * @constructor
 * @param {workbreeze.storage} storage Storage
 * @param {Object} s Options
 */
workbreeze.sites = function(storage, s) {
	var self = this;
	
	/**
	 * Options
	 * @type {Object}
	 */
	var options = $.extend( {
		storagePath: 'sites',
		iconPrefix: 'sico',
		place: '#sites'
	}, s);

	/**
	 * Array of sites
	 * @type {Array} 
	 */
	var sites = [];

	/**
	 * Get local storage sites version
	 * @return {number} Site object version
	 */
	self.getLocalVersion = function() {
		var sver = storage.getVersion(options.storagePath);
	
		if (sver > 0) {
			var tmp = storage.get(options.storagePath);

			sites = tmp[1];
		}

		return sver;
	}
	
	/**
	 * Getter
	 * @param {number} index Index
	 * @return {Array} Site item
	 */
	self.get = function(index) {
		return sites[index];
	}

	/**
	 * Sites count
	 * @return {number} Sites count
	 */
	self.count = function() {
		return sites.length;
	}

	/**
	 * Load sites
	 * @param {!Object} val Load site objects from ajax request
	 */
	self.load = function(val) {
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
	
		storage.set(options.storagePath, sites, val['v']);
	}

	/**
	 * Init sites info
	 */
	self.init = function() {
		var splace = $(options.place);
		var sempty = settings.sites.length == 0;

		$(sites).each( function() {
			var site = this;

			var sp  = $('<span></span>')
				.addClass(options.iconPrefix)
				.addClass(options.iconPrefix + '_' + site[0])
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
				|| $.inArray(site[0], settings.sites) >= 0
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
}

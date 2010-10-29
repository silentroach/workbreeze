/**
 * Categories object
 * @constructor
 * @this {workbreeze.categories}
 * @param {workbreeze.storage} storage Storage
 * @param {workbreeze.locale} locale Locale
 * @param {Object} s Options
 */
workbreeze.categories = function(storage, locale, s) {
	var self = this;
	
	/**
	 * Options
	 * @type {Object}
	 */
	var options = $.extend( {
		storagePath: 'cats'
	}, s);

	/**
	 * Categories list
	 * @type {Array} 
	 */ 
	var cats = [];

	/**
	 * Get local storage categories version
	 * @return {number} Categories object version
	 */
	self.getLocalVersion = function() {
		var cver = storage.getVersion(options.storagePath);
	
		if (cver > 0) {
			var tmp = storage.get(options.storagePath);

			cats = tmp[1];
		}

		return cver;
	}
	
	/**
	 * Categories count
	 * @return {number} Categories count
	 */
	self.count = function() {
		return cats.length;
	}

	/**
	 * Load categories
	 * @param {!Object} val Load category objects from ajax request
	 */
	self.load = function(val) {
		var tmp = val['vl'];
	
		$(tmp).each( function() {
			var cat = this;

			var item = [];
			item[0] = cat['i'];  // id
			item[1] = cat['l'];  // lang val
		
			cats[item[0]] = item; 
		} );
	
		storage.set(options.storagePath, cats, val['v']);
	}

	/**
	 * Init cats info
	 */
	self.init = function() {
		var cplace = $('#categories');
		var cempty = settings.categories.length == 0;
	
		for (var i in cats) {
			var cat = cats[i];

			var sp = $('<span></span>')
				.html(locale.translate(cat[1]));

			var li = $('<li></li>')
				.addClass('checkable')
				.attr( {
					'id'   : 'c' + i,
					'cat' : i
				} )
				.click(function() {
					$(this).toggleClass('checked');
					handleFilter();
				} );

			if (
				cempty
				|| $.inArray(i, settings.categories) >= 0
			) {
				li.addClass('checked');
			}

			if (cempty) {
				settings.addCat(i);
			}

			li.appendTo(cplace);
			sp.appendTo(li);
		}
	}
}

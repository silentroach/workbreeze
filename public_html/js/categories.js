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
		place: '#categories'
	}, s);

	var place = $(options.place);

	/**
	 * Categories list
	 * @type {Array}
	 */ 
	var cats = [];
	
	/**
	 * Selected categories list
	 * @type {Array}
	 */
	var selected = [];
	
	/**
	 * Toggle selected item
	 * TODO refactor and group
	 * @param {number} item
	 */
	var toggleSelected = function(item) {
		$('#c' + item, options.place).toggleClass('checked');
	
		var index = $.inArray(item, selected);
			
		if (index >= 0) {
			selected.splice(index, 1);
		} else {
			selected.push(item);
		}
	};
	
	/**
	 * Filter item identifier
	 * @const
	 * @type {string}
	 */
	self.identifier = 'cats';
	
	/**
	 * Filter item value
	 * @return {Array}
	 */
	self.getValue = function() {
		return selected;
	};
	
	/**
	 * Set the filter item value
	 * @param {Array} value Categories array.
	 */
	self.setValue = function(value) {
		selected = value || [];
	
		$('li', place).each( function() {
			var self = $(this);
		
			var tmp = self.attr('cat');
			
			if (tmp) {
				var tmpch  = self.hasClass('checked');
			
				if ($.inArray(tmp, selected) >= 0) {
					if (!tmpch) {
						self.addClass('checked');
					}
				} else {
					if (tmpch) {
						self.removeClass('checked');
					}
				}
			}
		} );
	};

	/**
	 * Select all the elements
	 */
	self.selectAll = function() {
		var items = [];

		for (var i = 0; i < cats.length; i++) {
			items.push(cats[i][0]);
		}

		self.setValue(items);
	};

	/**
	 * Get local storage categories version
	 * @return {number} Categories object version
	 */
	self.getLocalVersion = function() {
		var cver = storage.getVersion(self.identifier);
	
		if (cver > 0) {
			var tmp = storage.get(self.identifier);

			cats = tmp[1];
		}

		return cver;
	};
	
	/**
	 * Categories count
	 * @return {number} Categories count
	 */
	self.count = function() {
		return cats.length;
	};

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
	
		storage.set(self.identifier, cats, val['v']);
	};

	/**
	 * Check the job element
	 * @param {jQueryObject} jobElement Job element
	 * @return {boolean}
	 */
	self.checkJob = function(jobElement) {
		if (0 === selected.length) {
			return false;
		}

		var jobCats = jobElement.attr('cats');

		if (!jobCats) {
			jobCats = [];
		}

		for (var i = 0; i < jobCats.length; i++) {
			if ($.inArray(jobCats[i], selected) >= 0) {
				return true;
			}
		}

		return false;
	};

	/**
	 * onChanged handler
	 */
	self.onChanged = function() { };

	/**
	 * Init cats info
	 */
	self.init = function() {	
		for (var i in cats) {
			var cat = cats[i];

			var sp = $('<span></span>')
				.html(locale.translate(cat[1]));

			var li = $('<li></li>')
				.addClass('checkable')
				.attr( {
					'id'  : 'c' + i,
					'cat' : i
				} )
				.click(i, function(e) {
					toggleSelected(e.data);
					
					self.onChanged();
				} );

			li.appendTo(place);
			sp.appendTo(li);
		}
	};
};

/**
 * Categories object
 * @constructor
 * @this {workbreeze.categories}
 * @implement {workbreeze.filterItem}
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
	 * @todo refactor and group
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
	}
	
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
	}
	
	/**
	 * Set the filter item value
	 * @param {Object|string} value
	 */
	self.setValue = function(value) {
		selected = value || [];
		
		$('li', place).each( function() {
			var self = $(this);
		
			var tmp = self.attr('cat');
			
			if (tmp) {
				var tmpch  = self.hasClass('checked');
			
				if (tmp in selected) {
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
	}

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
	
		storage.set(self.identifier, cats, val['v']);
	}
	
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
	}
}

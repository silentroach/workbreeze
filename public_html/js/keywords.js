/**
 * Keywords filter object
 * @constructor
 * @this {workbreeze.keywords}
 * @param {Object} s Options
 */
workbreeze.keywords = function(s) {
	var self = this;
	
	/**
	 * Options
	 * @type {Object}
	 */
	var options = $.extend( {
		place: '#keywords',
		handlePause: 2000
	}, s);
	
	var keywordTimer = null;
	var place = $(options.place);
	
	/**
	 * Array of used keywords
	 * @type {Array} 
	 */
	var keys = [];
	
	/**
	 * Filter item identifier
	 * @const
	 * @type {string}
	 */
	self.identifier = 'keys';
	
	/**
	 * Filter item value
	 * @return {Array}
	 */
	self.getValue = function() {
		return keys;
	}
	
	/**
	 * Set the filter item value
	 * @param {Object|string} value
	 */
	self.setValue = function(value) {
		keys = value || [];
		
		place.val(keys.join(', '));
	}
	
	/**
	 * onChanged handler
	 */
	self.onChanged = function() { };
	
	var changed = function() {
		keys = [];
	
		var tmp = place.val().split(',');

		$(tmp).each( function() {
			var key = $.trim(this);
			
			if (
				'' !== key
				&& $.inArray(key, keys) < 0
			) {
				keys.push(key);
			}
		} );
	
		self.onChanged();	
	}
	
// ------------------------------------------------------
// initialization
// ------------------------------------------------------

	place
		.keyup(function(e) {
			if (null != keywordTimer) {
				clearTimeout(keywordTimer);
			}
	
			if (e.keyCode == 13) {
				changed();
			} else {
				keywordTimer = setTimeout(changed, options.handlePause);
			}
		});
}

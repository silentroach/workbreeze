var workbreeze = workbreeze || [];

workbreeze.locale = function(s) {
	var self = this;
	
	var settings = $.extend( {
		storage: undefined,
		storagePath: 'lang'
	}, s);

	/**
	 * Language array
	 * @type {Array} 
	 */ 
	var lang = [];

	/**
	 * Add leading zero to val
	 * @param {!number} i Number to check
	 * @return {string}
	 */
	var checkTimeVal = function(i) {
		if (i < 10) {
			return "0" + i;
		} else {
			return i.toString();
		}
	}

	/**
	 * Get a humanized label for time
	 * @param {Date} stamp Job unix timestamp
	 * @return {string}
	 */
	self.timeString = function(stamp) {
		return checkTimeVal(stamp.getHours()) + ':' + checkTimeVal(stamp.getMinutes());
	}

	/**
	 * Localize items on the page
	 * @param {JQuery} place Place to localize
	 */
	self.localize = function(place) {
		var tmp = (undefined !== place) ? place : $('body');

		$('.l', place).each(function() {
			var el = $(this);
		
			var tmp = el.attr('lp');
			if (tmp !== undefined) {
				el.attr('placeholder', self.translate(tmp));
			}
	
			tmp = el.attr('lv');
			if (tmp !== undefined) {
				el.html(self.translate(tmp));
			}
		
			tmp = el.attr('lt');
			if (tmp !== undefined) {
				el.attr('title', self.translate(tmp));
			}
		});
	}

	/**
	 * Get local storage lang version
	 * @return {number} Language object version
	 */
	self.getLocalVersion = function() {
		var lver = settings.storage.getVersion(settings.storagePath);
	
		if (lver > 0) {
			var tmp = settings.storage.get(settings.storagePath);
		
			lang = tmp[1];
		}

		return lver;
	}

	/**
	 * Get language value by index
	 * @param {!string} item Language index
	 * @return {string} Language value
	 */
	self.translate = function(item) {
		if (item in lang) {
			return lang[item];
		} else {
			return '';
		}
	}

	/**
	 * Load language
	 * @param {!Object} val Load language object from ajax request
	 */
	self.load = function(val) {
		lang = val['vl'];
	
		settings.storage.set(settings.storagePath, lang, val['v']);
	}
}

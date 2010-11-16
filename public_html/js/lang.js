/**
 * Locale object
 * @constructor
 * @this {Workbreeze.Locale}
 * @param {Workbreeze.Storage} storage Storage
 * @param {Object} s options
 */
Workbreeze.Locale = function(storage, s) {
	var self = this;
	
	/**
	 * Options
	 * @type {Object}
	 */
	var options = $.extend( {
		storagePath: 'lang',
		onChange: function(lang) { }
	}, s);

	/**
	 * Languages list
	 * @type {Array}
	 */
	var langs = [];

	/**
	 * Language arrays
	 * @type {Array} 
	 */ 
	var lang = [];

	/**
	 * Add leading zero to val
	 * @param {!number} i Number to check
	 * @return {string}
	 */
	var checkLeadZero = function(i) {
		return (i < 10) ? '0' + i : i.toString();
	};

	/**
	 * Get a humanized label for time
	 * @param {Date} stamp Job unix timestamp
	 * @return {string}
	 */
	self.timeString = function(stamp) {
		var current = new Date();

		var datesDiff = current.getDate() - stamp.getDate();
		var datestr = '';

		// TODO need to really localize to local format
		if (datesDiff == 1) {
			// yesterday
			datestr = self.translate('y') + ', ';
		} else if (datesDiff > 1) {
			datestr = checkLeadZero(stamp.getDate()) + '.' + checkLeadZero(stamp.getMonth()) + '.' + stamp.getFullYear() + ', ';
		}

		return datestr + checkLeadZero(stamp.getHours()) + ':' + checkLeadZero(stamp.getMinutes());
	};

	/**
	 * Localize items on the page
	 * @param {jQueryObject} place Place to localize
	 */
	self.localize = function(place) {
		/** @type {jQueryObject} **/ var realPlace = (undefined !== place) ? place : $('body');

		$('.l', realPlace).each(function() {
			var el = $(this);
		
			/** @type {string} **/ var tmp = el.attr('lp') || '';
			if (tmp !== '') {
				el.attr('placeholder', self.translate(tmp));
			}
	
			tmp = el.attr('lv') || '';
			if (tmp !== '') {
				el.html(self.translate(tmp));
			}
		
			tmp = el.attr('lt') || '';
			if (tmp !== '') {
				el.attr('title', self.translate(tmp));
			}
		});
	};

	/**
	 * Get local storage lang version
	 * @return {number} Language object version
	 */
	self.getLocalVersion = function() {
		var lver = storage.getVersion(options.storagePath);

		if (lver > 0) {
			var tmp = storage.get(options.storagePath);

			var sobj = tmp[1];

			langs = sobj['a'];
			lang  = sobj['v'];
		}

		return lver;
	};

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
	};

	/**
	 * Load language
	 * @param {!Object} val Load language object from ajax request
	 */
	self.load = function(val) {
		lang  = val['vl'];
		langs = val['a'];

		var sobj = {
			'a': langs,
			'v': lang
		}

		storage.set(options.storagePath, sobj, val['v']);
	};

	/**
	 * Visualize language changer
	 * @param {string} selector Selector for the tag to place selector.
	 */
	self.setTrigger = function(selector) {
		var $place = $(selector);

		$place.contents().remove();

		var current = lang['_'];

		for (var lname in langs) {
			var lfname = langs[lname];

			var $li = $('<li></li>')
				.attr('title', lfname)
				.html(lname)
				.appendTo( $place );

			if (lname === current) {
				$li.addClass('selected');
			}
		}
	}

};

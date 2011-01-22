/**
 * Locale object
 * @constructor
 * @this {Workbreeze.Locale}
 * @param {Object} s options
 */
Workbreeze.Locale = function(s) {
	var self = this;
	
	/**
	 * Language array
	 * @type {Array} 
	 */ 
	var lang = window['i18n_wb'] || [];

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

};

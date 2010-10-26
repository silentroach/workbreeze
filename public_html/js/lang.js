/** @type {Array} **/ var lang = [];

/**
 * Add leading zero to val
 * @param {!number} i Number to check
 * @return {string}
 */
function checkTimeVal(i) {
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
function humanizedTime(stamp) {
	return checkTimeVal(stamp.getHours()) + ':' + checkTimeVal(stamp.getMinutes());
}

/**
 * Localize items on the page
 * @param {JQuery} place Place to localize
 */
function localize(place) {
	var tmp = (undefined !== place) ? place : $('body');

	$('.l', place).each(function() {
		var el = $(this);
		
		var tmp = el.attr('lp');
		if (tmp !== undefined) {
			el.attr('placeholder', langVal(tmp));
		}
	
		tmp = el.attr('lv');
		if (tmp !== undefined) {
			el.html(langVal(tmp));
		}
		
		tmp = el.attr('lt');
		if (tmp !== undefined) {
			el.attr('title', langVal(tmp));
		}
	});
}

/**
 * Get local storage lang version
 * @return {number} Language object version
 */
function getLangVersion() {
	var lver = storage.getVersion(options.elementLang);
	
	if (lver > 0) {
		var tmp = storage.get(options.elementLang);
		
		lang = tmp[1];
	}

	return lver;
}

/**
 * Get language value by index
 * @param {!string} item Language index
 * @return {string} Language value
 */
function langVal(item) {
	if (item in lang) {
		return lang[item];
	} else
		return '';
}

/**
 * Load language
 * @param {!Object} val Load language object from ajax request
 */
function loadLang(val) {
	lang = val['vl'];
	
	storage.set(options.elementLang, lang, val['v']);
}

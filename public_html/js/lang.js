/** @type {Array} **/ var lang = [];

/**
 * Localize items on the page
 * @param {JQuery} place Place to localize
 */
function localize(place) {
	var tmp = $('body');

	if ('undefined' == typeof(place))
		tmp = place;

	$('.l', place).each(function() {
		var el = $(this);
		
		var tmp = el.attr('lp');
		if (tmp !== undefined) {
			el.attr('placeholder': langVal(tmp));
		}
	
		tmp = el.attr('lv');
		if (tmp !== undefined) {
			el.html(langVal(tmp));
		}
		
		tmp = el.attr('lt');
		if (tmp !== undefined) {
			el.attr('title': langVal(tmp));
		}
	});
}

/**
 * Get local storage lang version
 * @return {number} Language object version
 */
function getLangVersion() {
	var lver = getLocalStorageItemVersion(options.elementLang);
	
	if (lver > 0) {
		var tmp = getLocalStorageItem(options.elementLang);
		
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
	
	addLocalStorageItem(options.elementLang, val['v'], lang);
}

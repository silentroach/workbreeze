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
		if ($(this).hasClass('lp')) {
			$(this).attr( {
				'placeholder': langVal($(this).attr('lp'))
			} );
		}

		if ($(this).hasClass('lv')) {
			$(this).html( langVal($(this).attr('lv')) )
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
		lang = getLocalStorageItem(options.elementLang);
	}

	return lver;
}

/**
 * Get language value by index
 * @param {!string} item Language index
 * @return {string} Language value
 */
function langVal(item) {
	if ('undefined' == typeof(lang['vl']))
		return '';
		
	if ('string' != typeof(lang['vl'][item]))
		return '';
		
	return lang['vl'][item];
}

/**
 * Load language
 * @param {!Object} val Load language object from ajax request
 */
function loadLang(val) {
	lang = val;
	
	addLocalStorageItem(options.elementLang, lang['v'], lang['vl']);
}

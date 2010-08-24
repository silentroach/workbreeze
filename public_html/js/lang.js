/** @type {Array} **/ var lang = [];

/**
 * Localize items on the page
 */
function localize() {
	$('.l').each(function() {
		if (
			$(this).hasClass('lp')
			&& undefined != $(this).attr('lp')
		) {
			$(this).attr( {
				'placeholder': langVal($(this).attr('lp'))
			} );
		}

		if (
			$(this).hasClass('lv')
			&& undefined != $(this).attr('lv')
		) {
			$(this).html( langVal($(this).attr('lv')) )
		}
	});
}

/**
 * Get local storage lang version
 * @return {number} Language object version
 */
function getLangVersion() {
	if (!is_ls)
		return 0;

	try {
		lang = JSON.parse(localStorage.getItem('lang'));
	} catch (err) {
		return 0;
	}
	
	if (!lang)
		return 0;

	if (
		'undefined' == typeof(lang)
		|| 'undefined' == typeof(lang['v'])
	)
		return 0;

	return Math.floor(lang['v']);
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
	
	if (is_ls) {
		localStorage.setItem('lang', JSON.stringify(lang));
	}
}

/** @type {Array} **/ var keywords = [];
/** @type {Array} **/ var selsites = [];

function handleFilter() {
	var tmp = $('#keyword').val().trim();
	selsites = [];
	
	$('li', '#sites').each( function() {
		if ($(this).hasClass('checked')) {
			selsites.push(parseInt($(this).attr('site')));
		}
	} );
	
	if ('' == tmp) {
		keywords = [];
	} else {	
		keywords = tmp.split(',');
	}
	
	checkFeedForFilter();
}

/**
 * @param {jQuery} element
 */
function checkJobForFilter(element) {
	var str = $('.title', element).html() + $('.desc', element).html();
	str = str.toLowerCase();
	
	var keyfound = false;

	if (0 != keywords.length)	{
		for (var i = 0; i < keywords.length; i++) {
			if (str.indexOf(keywords[i].toLowerCase()) >= 0) {
				keyfound = true;
				break;
			}
		}
	} else
		keyfound = true;
	
	if (
		selsites.indexOf(parseInt(element.attr('site'))) >= 0
		&& keyfound
	) {
		if (
			!element.hasClass(options.classSelected)
			|| element.hasClass(options.classNotSelected)
		) {
			element
				.removeClass(options.classNotSelected)
				.addClass(options.classSelected);
			
			element.animate( {
				'opacity': 1
			} );
		}
	} else if (
		!element.hasClass(options.classNotSelected)
		|| element.hasClass(options.classSelected)
	) {
		element
			.removeClass(options.classSelected)
			.addClass(options.classNotSelected);
		
		element.animate( {
			'opacity': 0.2
		} );
	}
}

function checkFeedForFilter() {	
	for (var i = 0; i < joblist.length; i++) {
		checkJobForFilter(joblist[i]);
	}
}

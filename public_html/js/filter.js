/** @type {Array} **/ var keywords = [];
/** @type {Array} **/ var selsites = [];
/** @type {Array} **/ var selcats  = [];

function handleFilter() {
	var tmp = $('#keyword').val().trim();
	selsites = [];
	selcats  = [];
	
	$('li', '#sites').each( function() {
		if ($(this).hasClass('checked')) {
			selsites.push(parseInt($(this).attr('site')));
		}
	} );

	$('li', '#categories').each( function() {
		if ($(this).hasClass('checked')) {
			selcats.push(parseInt($(this).attr('cat')));
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
	
	var wrong = !(selsites.indexOf(parseInt(element.attr('site'))) >= 0);
	
	if (!wrong) {
		var cts = element.attr('cats').split(',');

		var cwrong = true;
	
		for (var i = 0; i < cts.length; i++) {
			if (selcats.indexOf(parseInt(cts[i])) >= 0) {
				cwrong = false;
				break;
			}
		}
		
		if (cwrong) {
			wrong = true;
		}
	}

	if (
		!wrong
		&& 0 != keywords.length
	) {
		wrong = true;
	
		for (var i = 0; i < keywords.length; i++) {
			if (str.indexOf(keywords[i].toLowerCase()) >= 0) {
				wrong = false;
				break;
			}
		}
	}
	
	if (!wrong) {
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

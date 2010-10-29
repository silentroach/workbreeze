/** @type {Boolean} **/ var streamAutoPause = false;

function handleFilter() {
	var tmp = $.trim($('#keyword').val());

	settings.selsites = [];
	settings.selcats  = [];

	$('li', '#sites').each( function() {
		var el = $(this);

		if (el.hasClass('checked')) {
			settings.addSite(el.attr('site'));
		}
	} );

	$('li', '#categories').each( function() {
		var el = $(this);
	
		if (el.hasClass('checked')) {
			settings.addCat(el.attr('cat'));
		}
	} );

	settings.keywords = [];

	if ('' != tmp) {
		/** @type {Array} **/ var keys = tmp.split(',');

		for (var i = 0; i < keys.length; i++) {
			var tmpk = $.trim(keys[i]);

			if ('' != tmpk) {
				settings.addKeyword(tmpk);
			}
		}
	}

	if (
		0 == settings.selsites.length
		|| 0 == settings.selcats.length
	) {
		if (!paused) {
			streamAutoPause = true;
			streamPause();
		}
	} else if (streamAutoPause) {
		streamAutoPause = false;
		streamPlay();
	}

	settings.save();

/* <debug> */
	console.group('new filter');
	console.log('sites', settings.selsites);
	console.log('cats', settings.selcats);
	if (0 < settings.keywords.length) 
		console.log('keys', settings.keywords);
	console.groupEnd();
/* </debug> */

	if (!settings.filterMode) {
		checkFeedForFilter();
	}
}

function jobSelectAll() {
	for (var i in joblist) {
		jobSelect(joblist[i]);
	}
}

/**
 * @param {jQuery} element
 */
function jobSelect(element) {
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
}

/**
 * @param {jQuery} element
 */
function jobUnselect(element) {
	if (
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

/**
 * @param {jQuery} element
 */
function checkJobForFilter(element) {
	if (
		0 == settings.selsites.length
		|| 0 == settings.selcats.length
	) {
		jobSelect(element);
		return;
	}

	var str = $('li.k', element).html();
	
	var wrong = $.inArray(element.attr('site'), settings.selsites) < 0;
	
	if (!wrong) {
		var cts = element.attr('cats').split(',');

		var cwrong = true;
	
		for (var i = 0; i < cts.length; i++) {
			if ($.inArray(cts[i], settings.selcats) >= 0) {
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
		&& 0 != settings.keywords.length
	) {
		wrong = true;
	
		for (var i = 0; i < settings.keywords.length; i++) {
			if (str.indexOf(settings.keywords[i].toLowerCase()) >= 0) {
				wrong = false;
				break;
			}
		}
	}
	
	if (!wrong) {
		jobSelect(element);
	} else {
		jobUnselect(element);
	}
}

function checkFeedForFilter() {	
	for (var i = 0; i < joblist.length; i++) {
		checkJobForFilter(joblist[i]);
	}
}

/** @type {Array} **/ var keywords = [];
/** @type {Array} **/ var selsites = [];
/** @type {Array} **/ var selcats  = [];

function handleFilter() {
	var tmp = $('#keyword').val().trim();
	selsites = [];
	selcats  = [];
	
	$('li', '#sites').each( function() {
		if ($(this).hasClass('checked')) {
			selsites.push($(this).attr('site'));
		}
	} );

	$('li', '#categories').each( function() {
		if ($(this).hasClass('checked')) {
			selcats.push($(this).attr('cat'));
		}
	} );
	
	keywords = [];

	if ('' != tmp) {
		keys = tmp.split(',');

		for (var i in keys) {
			var tmp = keys[i].trim();
			if ('' != tmp) {
				keywords.push(tmp);
			}
		}
	}
	
	if (
		0 == selsites.length
		|| 0 == selcats.length
	) {
		streamAutoPause = true;
		streamPause();
	} else if (streamAutoPause) {
		streamPlay();
	}

/* <debug> */
	console.group('new filter');
	console.log('sites', selsites);
	console.log('cats', selcats);
	if (0 < keywords.length) 
		console.log('keys', keywords);
	console.groupEnd();
/* </debug> */
	
	checkFeedForFilter();
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
		0 == selsites.length
		|| 0 == selcats.length
	) {
		jobSelect(element);
		return;
	}

	var str = $('li.k', element).html();
	
	var wrong = selsites.indexOf(element.attr('site')) < 0;
	
	if (!wrong) {
		var cts = element.attr('cats').split(',');

		var cwrong = true;
	
		for (var i = 0; i < cts.length; i++) {
			if (selcats.indexOf(cts[i]) >= 0) {
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
	
		for (var i in keywords) {
			if (str.indexOf(keywords[i].toLowerCase()) >= 0) {
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
	for (var i in joblist) {
		checkJobForFilter(joblist[i]);
	}
}

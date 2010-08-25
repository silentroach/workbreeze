/** @type {Array} **/ var keywords = [];
/** @type {Array} **/ var selsites = [];

function handleFilter() {
	$('#keyword, #sites')
		.animate( {
			'opacity': 0.8
		}, function() {
			$(this).
				animate( {
					'opacity': 1
				} );
		} );
		
	var tmp = $('#keyword').val().trim();
	selsites = [];
	
	$('input', '#sites').each( function() {
		if ($(this).attr('checked')) {
			selsites.push($(this).attr('site'));
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
		selsites.indexOf(element.attr('site')) >= 0
		&& keyfound
	) {
		if (
			!element.hasClass('jsel')
			|| element.hasClass('jrem')
		) {
			element
				.removeClass('jrem')
				.addClass('jsel');
			
			element.animate( {
				'opacity': 1
			} );
		}
	} else if (
		!element.hasClass('jrem')
		|| element.hasClass('jsel')
	) {
		element
			.removeClass('jsel')
			.addClass('jrem');
		
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

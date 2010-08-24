/** @type {number} **/ var lastStamp = 0;
var queueTimer;
var newTimer;
var filterTimer;
/** @const */ var checkInterval = 30000;
/** @type {jQuery} **/ var jobTemplate;
/** @type {jQuery} **/ var jobPlace;

/** @type {jQuery} **/ var playbtn;
/** @type {jQuery} **/ var pausebtn;

/** @type {Array} **/ var keywords = [];
/** @type {Array} **/ var selsites = [];

/** @type {Array} **/ var queue    = [];
/** @type {Array} **/ var joblist  = [];
/** @type {Array} **/ var sites    = [];

function checkJobPlace() {
	while (joblist.length > 20) {
		tmpEl = joblist.shift();
		tmpEl.fadeOut('slow', function() { 
			$(this).remove();
		});
	}
}

function checkNewJobs() {
	dropNewTimer();

	$.ajax({
		url: '/up',
		type: 'POST',
		data: {
			'stamp': lastStamp
		},
		dataType: 'json',
		success: /** @param {*} data JSON data **/ function(data) {
			setNewTimer(checkInterval);

			parseJobs(data, false);
		},
		error: function() {
			setNewTimer(checkInterval);
		}
	});
}

function dropQueueTimer() {
	if (null != queueTimer) {
		clearTimeout(queueTimer);
	}
}

function dropNewTimer() {
	if (null != newTimer) {
		clearTimeout(newTimer);
	}
}

/**
 * Sets the queue checker timer
 * @param {!number} interval Interval
 */
function setQueueTimer(interval) {
	dropQueueTimer();
	queueTimer = setInterval(function() { checkQueue(); }, interval);
}

/**
 * Sets the new jobs checker timer
 * @param {!number} interval Interval
 */
function setNewTimer(interval) {
	dropNewTimer();
	newTimer = setInterval(function() { checkNewJobs(); }, interval);
}

/**
 * Pop the job from queue
 * @param {!boolean} instantly Disable slideDown animation
 */
function popFromQueue(instantly) {
	var tmpEl = queue.pop();

	joblist.push(tmpEl);
	
	tmpEl
		.hide()
		.prependTo(jobPlace);
		
	if (!instantly)
		tmpEl.slideDown('slow', function() {
			checkJobForFilter($(this));
		} );
	else
		tmpEl.show();

	checkJobPlace();
}

function checkQueue() {
	if (queue.length > 0)
		popFromQueue(false);
}

/**
 * Add job to queue
 * @param {!Object} job Job object
 * @param {!boolean} instantly Disable slideDown animation
 */
function addJob(job, instantly) {
	if (job.stamp > lastStamp) {
		lastStamp = job.stamp;
	}

	var jobEl = jobTemplate.clone();

	jobEl
		.attr( {
			'site': job.site
		} )
		.hide();

	lnk = $("<a>")
		.addClass('sico')
		.addClass('sico_' + sites[job.site].folder)
		.attr({
			'href': '/jobs/' + sites[job.site].folder + '/' + job.id + '.html',
			'title': job.title + ' ' + langVal('on') + ' ' + sites[job.site].name
		})
		.html(job.title)
		.appendTo($('li.title', jobEl));

	$('li.desc', jobEl).html(job.desc);
	
	var stmp = new Date(job.stamp * 1000);
	
	$('li.time', jobEl).html(
		checkTimeVal(stmp.getHours()) + ':' +
		checkTimeVal(stmp.getMinutes())
	);
	
	queue.push(jobEl);
	
	if (instantly)
		popFromQueue(instantly);
}

/**
 * Parse job info
 * @param {!Array} job Job info array
 * @param {!boolean} instantly Disable slideDown animation
 */
function parseJobs(jobs, instantly) {
	for (var i = jobs.length - 1; i >= 0; i--) {
		var job = {
			id:    jobs[i]['i'],
			site:  jobs[i]['s'],
			stamp: jobs[i]['st'],
			title: jobs[i]['t'],
			desc:  jobs[i]['d']
		};
		
		addJob(job, instantly);
	}
}

/**
 * Parse sites info
 * @param {!Array} s sites info array
 */
function parseSites(s) {
	var splace = $('#sites');

	for (var i = 0; i < s.length; i++) {				
		var site = s[i];
		
		var id = site['i'];
		
		var item = {
			folder: site['f'],
			name:  site['n'],
			url:    site['u']
		}
	
		sites[id] = item;
		
		selsites.push(id);
		
		var c = $('<input />')
			.attr( {
				'type'   : 'checkbox',
				'id'     : 'c' + id,
				'site'   : id,
				'checked': 'checked'
			} )
			.click(handleFilter);
			
		var l = $('<label></label>')
			.attr( {
				'for' : 'c' + id
			} )
			.addClass('sico')
			.addClass('sico_' + item.folder)
			.html(item.name);
			
		var li = $('<li></li>');
		
		c.appendTo(li);
		l.appendTo(li);		
		li.appendTo(splace);			
	}
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

function init() {
	finit();

	jobTemplate = $('ul.job:first');
	jobPlace    = $('#right');
	
	playbtn = $('#play');
	pausebtn = $('#pause');
	
	pausebtn.click(function() {
		pausebtn.slideUp('slow');
		playbtn.slideDown('slow');
	
		queue = [];
		dropNewTimer();
	} );
	
	playbtn.click(function() {
		playbtn.slideUp('slow');
		pausebtn.slideDown('slow');

		lastStamp = Math.round(new Date().getTime() / 1000);
		setNewTimer(5000);
	} );
	
	setQueueTimer(5000);
	setNewTimer(5000);
	
	// removing right content
	$('#right > *').remove();
	
	// init request
	$.ajax({
		url: '/init',
		type: 'POST',
		data: {
			lang: getLangVersion()
		},
		dataType: 'json',
		success: /** @param {*} data JSON data **/ function(data) {
			if ('undefined' != typeof(data['l']))
				loadLang(data['l']);

			localize();
			
			parseSites(data['s']);			
			parseJobs(data['j'], true);
		}
	});
	
	$('#keyword')
		.keyup(function(e) {
			if (null != filterTimer) {
				clearTimeout(filterTimer);
			}
	
			if (e.keyCode == 13) {
				handleFilter();
			} else {
				filterTimer = setTimeout(handleFilter, 2000);
			}
		});
}

$( function() {
	init();
} );

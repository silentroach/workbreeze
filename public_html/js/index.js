/**
 * @type {number}
 */
var lastStamp = 0;
var queueTimer;
var newTimer;
var filterTimer;
/** @const */ var checkInterval = 30000;
var jobTemplate;
var jobPlace;
var keywords = [];

var queue    = [];
var joblist  = [];
var sites    = [];
var lang     = [];

/**
 * Check leading zero in single char int
 * @param {!number} i Number
 * @return {string}
 */ 
function checkTimeVal(i) {
	if (i < 10) {
		i = "0" + i;
	}

	return i;
}

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
		success: function(data) {
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
			checkJobForKeys($(this));
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

	jobEl.hide();

	lnk = $("<a>")
		.addClass('sico')
		.addClass('sico_' + sites[job.site].folder)
		.attr({
			'href': '/jobs/' + sites[job.site].folder + '/' + job.id + '.html'
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
			id:    jobs[i].i,
			site:  jobs[i].s,
			stamp: jobs[i].st,
			title: jobs[i].t,
			desc:  jobs[i].d
		};
		
		addJob(job, instantly);
	}
}

/**
 * Parse sites info
 * @param {!Array} s sites info array
 */
function parseSites(s) {
	for (var i = 0; i < s.length; i++) {				
		var site = s[i];
	
		sites[site.i] = {
			folder: site.f,
			name:  site.n,
			url:    site.u
		}
	}
}

/**
 * Localize items on the page
 */
function localize() {
	$('.l').each(function() {
		if (
			$(this).hasClass('lp')
			&& undefined != $(this).attr('lp')
			&& undefined != lang[ $(this).attr('lp') ]
		) {
			$(this).attr( {
				'placeholder': lang[$(this).attr('lp')]
			} );
		}
	});
}

function checkJobForKeys(element) {
	var str = $('.title', element).html() + $('.desc', element).html();
	str = str.toLowerCase();
	
	var found = false;

	if (0 != keywords.length)	{
		for (var i = 0; i < keywords.length; i++) {
			if (str.indexOf(keywords[i].toLowerCase()) >= 0) {
				found = true;
				break;
			}
		}
	}
	
	if (found) {
		if (!element.hasClass('jsel')) {
			element.addClass('jsel');
			
			element.animate( {
				'margin-left': '10px'
			} );
		}
	} else if (element.hasClass('jsel')) {
		element.removeClass('jsel');
		
		element.animate( {
			'margin-left': '0px'
		} );
	}
}

function checkFeedForKeys() {	
	for (var i = 0; i < joblist.length; i++) {
		checkJobForKeys(joblist[i]);
	}
}

function handleFilter() {
	$('#keyword')
		.animate( {
			'opacity': 0.7
		}, function() {
			$(this).
				animate( {
					'opacity': 1
				} );
		} );
		
	var tmp = $('#keyword').val().trim();
	
	if ('' == tmp) {
		keywords = [];
	} else {	
		keywords = tmp.split(',');
	}
	
	checkFeedForKeys();
}

function init() {
	jobTemplate = $('ul.job:first');
	jobPlace    = $('#right');
	
	setQueueTimer(5000);
	setNewTimer(5000);
	
	// removing right content
	$('#right > *').remove();
	
	// init request
	$.ajax({
		url: '/init',
		dataType: 'json',
		success: function(data) {
			lang = data.l;
			localize();
			
			parseSites(data.s);			
			parseJobs(data.j, true);
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

/**
 * @type {number}
 */
var lastStamp = 0;
var queueTimer;
var newTimer;
/** @const */ var checkInterval = 30000;
var jobTemplate;
var jobPlace;

var queue    = [];
var joblist  = [];
var sites    = [];

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
		tmpEl.slideDown('slow');
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
		addJob(jobs[i], instantly);
	}
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
			dsites = data.sites;
				
			for (var i = 0; i < dsites.length; i++) {				
				var dsite = dsites[i];
				
				sites[dsite.id] = {
					folder: dsite.folder,
					name:  dsite.name,
					url:    dsite.url
				}
			}
			
			var jobs = data.jobs;
			
			parseJobs(jobs, true);
		}
	});
}

$( function() {
	init();
} );

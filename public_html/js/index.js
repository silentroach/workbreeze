/**
 * @type {number}
 */
var lastStamp = 0;
var queueTimer;
var newTimer;
/** @const */ var checkInterval = 60000;
var jobTemplate;
var jobPlace;

var queue = [];
var sites = [];

function checkNewJobs() {
	dropNewTimer();

	$.ajax({
		url: '/j',
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

function setQueueTimer(interval) {
	dropQueueTimer();
	queueTimer = setInterval(function() { checkQueue(); }, interval);
}

function setNewTimer(interval) {
	dropNewTimer();
	newTimer = setInterval(function() { checkNewJobs(); }, interval);
}

function popFromQueue(instantly) {
	tmpEl = queue.pop();
	
	tmpEl
		.prependTo(jobPlace);
		
	if (!instantly)
		tmpEl.slideDown('slow');
	else
		tmpEl.show();
}

function checkQueue() {
	if (queue.length > 0)
		popFromQueue(false);
}

function addJob(job, instantly) {
	if (job.stamp > lastStamp) {
		lastStamp = job.stamp;
	}

	jobEl = jobTemplate.clone();

	jobEl.hide();

	lnk = $("<a>")
		.attr({
			'href': '/jobs/' + sites[job.site].folder + '/' + job.id + '.html'
		})
		.html(job.title)
		.appendTo($('li.title', jobEl));

	$('li.desc', jobEl).html(job.desc);
	
	stmp = new Date(job.stamp * 1000);
	
	$('li.time', jobEl).html(stmp.toLocaleTimeString());
	
	queue.push(jobEl);
	
	if (instantly = 1)
		popFromQueue(instantly);
}

function parseJobs(jobs, instantly) {
	for (i = jobs.length - 1; i >= 0; i--) {
		job = jobs[i];
			
		pjob = {
			site:  job[0],
			id:    job[1],
			stamp: job[2],
			title: job[3],
			desc:  job[4]
		};
		
		addJob(pjob, instantly);
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
			dsites = data[0];
				
			for (i = 0; i < dsites.length; i++) {				
				dsite = dsites[i];
				
				sites[dsite[0]] = {
					folder: dsite[1],
					name: dsite[2],
					url: dsite[3]
				}
			}
			
			jobs = data[1];
			
			parseJobs(jobs, true);
		}
	});
}

$( function() {
	init();
} );

/**
 * @type {number}
 */
var lastStamp = 0;
var checkTimer;
/** @const */ var checkInterval = 30000;
var jobTemplate;
var jobPlace;
var queue = [];
var sites = [];

function checkQueue() {

}

function dropTimer() {
	if (null != checkTimer) {
		clearTimeout(checkTimer);
	}
}

function setTimer(interval) {
	dropTimer();
	checkTimer = setInterval(function() { checkQueue(); }, 5000);
}

function popFromQueue() {
	tmpEl = queue.pop();
	
	tmpEl
		.prependTo(jobPlace)
		.slideDown('slow');
}

function checkQueue() {
	if (queue.length > 0)
		popFromQueue();
}

function addJob(job, instantly) {
	jobEl = jobTemplate.clone();

	jobEl.hide();

	lnk = $("<a>")
		.attr({
			'href': '/jobs/' + sites[job.site].folder + '/' + job.id + '.html'
		})
		.html(job.title)
		.appendTo($('li.title', jobEl));

	$('li.desc', jobEl).html(job.desc);
	$('li.time', jobEl).html(job.time);
	
	queue.push(jobEl);
	
	if (instantly = 1)
		popFromQueue();
}

function init() {
	jobTemplate = $('ul.job:first');
	jobPlace    = $('#right');
	
	setTimer(5000);
	
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
			
			for (i = 0; i < jobs.length; i++) {
				job = jobs[i];
					
				pjob = {
					site: job[0],
					id: job[1],
					stamp: job[2],
					title: job[3],
					desc: job[4]
				};
				
				addJob(pjob, true);				
			}
		}
	});
}

$( function() {
	init();
} );

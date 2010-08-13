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

function addJob(job) {
	jobEl = jobTemplate.clone();

	jobEl.hide();

	$('li.title', jobEl).html(job.title);
	$('li.desc', jobEl).html(job.description);
	$('li.time', jobEl).html(job.time);
	
	queue.push(jobEl);
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
					name: dsite[1],
					url: dsite[2]
				}
			}
		}
	});
}

$( function() {
	init();
} );

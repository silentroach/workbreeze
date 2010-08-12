/**
 * @type {number}
 */
var lastStamp = 0;
var checkTimer;
/** @const */ var checkInterval = 30000;
var jobTemplate;
var jobPlace;
var queue = [];

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
}

$( function() {
	init();
} );

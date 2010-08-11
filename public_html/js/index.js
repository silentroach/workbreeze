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
	
//	alert(job.description);

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
	
	job = {
		title: 'test',
		description: 'desc',
		time: '23:20'
	};
	
	job2 = {
		title: 'blabla',
		description: 'hrenhren',
		time: '21:09'
	}
	
	addJob(job);
	addJob(job2);
	
//	jobTemplate.appendTo(jobPlace).show();
}

$( function() {
	init();
} );

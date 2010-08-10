var lastStamp = 0;
var jobTemplate;
var jobPlace;

function addJob(job) {
	jobEl = jobTemplate.clone();
	
//	alert(job.description);

	$('li.title', jobEl).html(job.title);
	$('li.desc', jobEl).html(job.description);
	$('li.time', jobEl).html(job.time);
	
	jobEl.appendTo(jobPlace).fadeIn('slow');
}

function init() {
	jobTemplate = $('ul.job:first');
	jobPlace    = $('#right');
	
	// removing right content
	$('#right > *').remove();
	
	job = {
		title: 'test',
		description: 'desc',
		time: '23:20'
	};
	
	addJob(job);
	
//	jobTemplate.appendTo(jobPlace).show();
}

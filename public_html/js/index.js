/** @type {number} **/ var lastStamp = 0;

var queueTimer;
var newTimer;
var filterTimer;

/** @type {Array} **/ var queue    = [];
/** @type {Array} **/ var joblist  = [];

var places = {
	/** @type {jQuery} **/ templateJob: null,
	/** @type {jQuery} **/ placeJob:    null,
	/** @type {jQuery} **/ buttonPlay:  null,
	/** @type {jQuery} **/ buttonPause: null
}

var options = {
	/** @const **/  checkInterval:   30000,
	/** @const **/ siteIconPrefix:   'sico',
	/** @const **/ animationSpeed:   'slow',
	
	/** @const **/ classSelected:    'jsel',
	/** @const **/ classNotSelected: 'jrem',
	
	/** @const **/ elementSites:     'sites',
	/** @const **/ elementLang:      'lang',
	/** @const **/ elementCats:      'cats',
	/** @const **/ elementJobStamp:  'jstamp'
}

function checkJobPlace() {
	while (joblist.length > 20) {
		tmpEl = joblist.shift();
		tmpEl.fadeOut(options.animationSpeed, function() { 
			$(this).remove();
		});
	}
}

function checkNewJobs() {
	dropNewTimer();
	
	var adata = {};
	
	adata[options.elementJobStamp] = lastStamp;

	$.ajax({
		url: '/up',
		type: 'POST',
		data: adata,
		dataType: 'json',
		success: /** @param {*} data JSON data **/ function(data) {
			if (null == data) 
				return;		
		
			if ('undefined' != typeof(_gaq)) {
				_gaq.push(['_trackEvent', 'Stream', 'Update']);
			}
		
			setNewTimer(options.checkInterval);

			if ('undefined' != typeof(data['j']))			
				parseJobs(data['j'], false);
		},
		error: function() {
			setNewTimer(options.checkInterval * 2);
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
	queueTimer = setInterval(checkQueue, interval);
}

/**
 * Sets the new jobs checker timer
 * @param {!number} interval Interval
 */
function setNewTimer(interval) {
	dropNewTimer();
	newTimer = setInterval(checkNewJobs, interval);
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
		.prependTo(places.placeJob);
		
	if (!instantly)
		tmpEl.slideDown(options.animationSpeed, function() {
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

	var jobEl = places.templateJob.clone();

	jobEl
		.attr( {
			'site': job.site,
			'cats': job.cats.join(',')
		} )
		.hide();

	lnk = $("<a>")
		.addClass(options.siteIconPrefix)
		.addClass(options.siteIconPrefix + '_' + sites[job.site].folder)
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
			cats:  jobs[i]['c'],
			desc:  jobs[i]['d']
		};
		
		addJob(job, instantly);
	}
}

function init() {
	$("#bfoot").css({'opacity': 0.7});

	finit();

	places.templateJob = $('ul.job:first');
	places.placeJob    = $('#right');
	
	places.buttonPlay  = $('#play');
	places.buttonPause = $('#play');
	
	places.buttonPause.click(function() {
		if ('undefined' != typeof(_gaq)) {
			_gaq.push(['_trackEvent', 'Stream', 'Pause']);
		}
	
		places.buttonPause.slideUp(options.animationSpeed);
		places.buttonPlay.slideDown(options.animationSpeed);
	
		queue = [];
		dropNewTimer();
	} );
	
	places.buttonPlay.click(function() {
		if ('undefined' != typeof(_gaq)) {
			_gaq.push(['_trackEvent', 'Stream', 'Resume']);
		}
	
		places.buttonPlay.slideUp(options.animationSpeed);
		places.buttonPause.slideDown(options.animationSpeed);

		lastStamp = Math.round(new Date().getTime() / 1000);
		setNewTimer(5000);
	} );
	
	setQueueTimer(5000);
	setNewTimer(5000);
	
	// removing right content
	$('#right > *').remove();
	
	var adata = {};
	
	adata[options.elementLang]     = getLangVersion();
	adata[options.elementSites]    = getSitesVersion();
	adata[options.elementCats]     = getCatsVersion();
	adata[options.elementJobStamp] = 0;
	
	// init request
	$.ajax({
		url: '/up',
		type: 'POST',
		data: adata,
		dataType: 'json',
		success: /** @param {*} data JSON data **/ function(data) {
			if (null == data) 
				return;
		
			if ('undefined' != typeof(data['l']))
				loadLang(data['l']);

			localize();
			
			if ('undefined' != typeof(data['c']))
				loadCats(data['c']);
				
			initCats();
			
			if ('undefined' != typeof(data['s']))
				loadSites(data['s']);
			
			initSites();
			
			if ('undefined' != typeof(data['j']))
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

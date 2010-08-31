/** @type {number} **/ var lastStamp = 0;
/** @type {number} **/ var updateCount = 0;

var queueTimer;
var newTimer;
var filterTimer;
var updating = false;
var updatingBottom = false;

var streamAutoPause = false;

/** @type {Array} **/ var queue    = [];
/** @type {Array} **/ var joblist  = [];

var places = {
	/** @type {jQuery} **/ templateJob: null,
	/** @type {jQuery} **/ placeJob:    null,
	/** @type {jQuery} **/ buttonPlay:  null,
	/** @type {jQuery} **/ buttonPause: null,
	/** @type {jQuery} **/ logo:        null
}

var options = {
	/** @type {number} **/ defJobPageCount: 30,
	/** @type {number} **/ maxJobPageCount: 30,
	/** @const **/ checkInterval:           30000,
	/** @const **/ siteIconPrefix:          'sico',
	/** @const **/ animationSpeed:          'slow',
	
	/** @const **/ classSelected:           'jsel',
	/** @const **/ classNotSelected:        'jrem',
	
	/** @const **/ elementSites:            'sites',
	/** @const **/ elementLang:             'lang',
	/** @const **/ elementCats:             'cats',
	/** @const **/ elementJobStamp:         'jstamp'
}

function checkJobPlace() {
	while (joblist.length > options.maxJobPageCount) {
/* <debug> */
		console.info('Removing last job');
/* </debug> */
	
		tmpEl = joblist.shift();
		tmpEl.fadeOut(options.animationSpeed, function() { 
			$(this).remove();
		});
	}
}

function updateRequest(adata, callback) {
	if (updating)
		return;
		
	updating = true;

	$.ajax({
		url: '/up',
		type: 'POST',
		data: adata,
		dataType: 'json',
		cache: false,
		success: function(data) {
			updating = false;
		
			if (null == data) 
				return;

/* <production>
			updateCount++;

			if (
				updateCount >= 10
				&& 'undefined' != typeof(_gaq)
			) {
				updateCount = 0;
				_gaq.push(['_trackEvent', 'Stream', '10 updates']);
			}
</production> */	
		
			if ('undefined' != typeof(data['l'])) {
/* <debug> */
				console.info('New lang pack');
/* </debug> */
				loadLang(data['l']);
			}
			
			if ('undefined' != typeof(data['c'])) {
/* <debug> */
				console.info('New categories pack');
/* </debug> */
				loadCats(data['c']);
			}
			
			if ('undefined' != typeof(data['s'])) {
/* <debug> */
				console.info('New sites pack');
/* </debug> */
				loadSites(data['s']);
			}
			
			if ('undefined' != typeof(data['j'])) {
/* <debug> */
				console.info('New jobs pack: ' + data['j'].length);
/* </debug> */
				parseJobs(data['j'], true);
			}
			
			if (undefined !== callback) {
				callback();
			}
		},
		error: function() {
			updating = false;
		
/* <debug> */
				console.error('Error while getting up response');
/* </debug> */
			setNewTimer(options.checkInterval * 2)		
		}
	});
}

function checkNewJobs() {
	dropNewTimer();

	var adata = {};	
	adata[options.elementJobStamp] = lastStamp;

	updateRequest(adata);
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
	var tmpJob = queue.pop();
	var tmpEl = tmpJob.element;

	joblist.push(tmpEl);
	
	tmpEl
		.hide();
		
	if (tmpJob.stamp < 0) {
		tmpEl.appendTo(places.placeJob);
		
/* <debug> */
		console.info('increment maxJobPageCount');
/* </debug> */
		
		options.maxJobPageCount++;
	} else {
		if (
			$(window).scrollTop() == 0
			&& options.maxJobPageCount - 2 >= options.defJobPageCount
		) {
/* <debug> */
			console.info('decrement maxJobPageCount');
/* </debug> */
		
			options.maxJobPageCount = options.maxJobPageCount - 2;
		}
	
		tmpEl.prependTo(places.placeJob);
	}
		
	if (!instantly)
		tmpEl.slideDown(options.animationSpeed, function() {
			checkJobForFilter($(this));
		} );
	else {
		tmpEl.show();
		checkJobForFilter(tmpEl);
	}

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
			'stamp': Math.abs(job.stamp),
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
	
	var jEl = {
		stamp: job.stamp,
		element: jobEl
	};
	
	queue.push(jEl);
	
	if (instantly) {
		popFromQueue(instantly);
	}
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

function streamPause() {
/* <production>
	if ('undefined' != typeof(_gaq)) {
		_gaq.push(['_trackEvent', 'Stream', 'Pause']);
	}
</production> */

	places.buttonPause.slideUp(options.animationSpeed);
	places.buttonPlay.slideDown(options.animationSpeed);

	queue = [];
	dropNewTimer();
}

function streamPlay() {
	if (
		0 == selsites.length
		|| 0 == selcats.length
	) {
		return;
	}

	streamAutoPause = false;

/* <production>
	if ('undefined' != typeof(_gaq)) {
		_gaq.push(['_trackEvent', 'Stream', 'Resume']);
	}
</production> */

	places.buttonPlay.slideUp(options.animationSpeed);
	places.buttonPause.slideDown(options.animationSpeed);

	lastStamp = Math.round(new Date().getTime() / 1000);
	setNewTimer(5000);
}

function updateBottom() {
	updatingBottom = true;

	dropNewTimer();

	var firstStamp = $('#right ul:last').attr('stamp');

/* <debug> */
	console.info('update less than ' + firstStamp);
/* </debug> */

	var adata = {};	
	adata[options.elementJobStamp] = -firstStamp;

	updateRequest(adata, function() {
		updatingBottom = false;
	});
}

function init() {
	$("#bfoot").css({'opacity': 0.7});
	
	finit();

	places.logo        = $('#logo');
	places.templateJob = $('ul.job:first');
	places.placeJob    = $('#right');
	
	places.buttonPlay  = $('#play');
	places.buttonPause = $('#pause');
	
	places.buttonPause.click(streamPause);
	places.buttonPlay.click(streamPlay);
	
	places.logo.ajaxStart(function() {
		$(this).animate({
			'opacity': 0.7
		}, options.animationSpeed);
	});
	
	places.logo.ajaxStop(function() {
		$(this).animate({
			'opacity': 1
		});
	});

	setQueueTimer(5000);
	setNewTimer(5000);
	
	// removing right content
	$('#right > *').remove();
	
	var adata = {};
	
	adata[options.elementLang]     = getLangVersion();
	adata[options.elementSites]    = getSitesVersion();
	adata[options.elementCats]     = getCatsVersion();
	adata[options.elementJobStamp] = 0;
	
	updateRequest(adata, function() {
		$('html, body').css({scrollTop:0});
	
		localize();
		initCats();
		initSites();
		
		$(window).scroll(function() {
			if (
				$(window).scrollTop() >= $(document).height() - $(window).height()
				&& !updatingBottom
			) {
				updateBottom();
			}
		} );
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

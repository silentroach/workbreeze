/** @type {number} **/ var lastStamp = 0;
/** @type {number} **/ var updateCount = 0;

var queueTimer;
var newTimer;
var filterTimer;
var updating = false;
var updatingBottom = false;
var helpVisible = false;

var streamAutoPause = false;

/** @type {Array} **/ var queue    = [];
/** @type {Array} **/ var joblist  = [];

var places = {
	/** @type {jQuery} **/ templateJob: null,
	/** @type {jQuery} **/ placeJob:    null,
	/** @type {jQuery} **/ buttonPlay:  null,
	/** @type {jQuery} **/ buttonPause: null,
	/** @type {jQuery} **/ logo:        null,
	/** @type {jQuery} **/ keyword:     null
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

function checkNewJobs() {
	var adata = {};	
	adata[options.elementJobStamp] = lastStamp;

	$.up({
		data: adata,
		success: function(data) {
			if (null == data) 
				return;
		
			if ('j' in data) {
/* <debug> */
				console.info('New jobs pack: ' + data['j'].length);
/* </debug> */
				parseJobs(data['j']);
			}
		
			setNewTimer(options.checkInterval);
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
 */
function popFromQueue() {
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
		
	tmpEl.show();
	checkJobForFilter(tmpEl);

	checkJobPlace();
}

function checkQueue() {
	if (queue.length > 0)
		popFromQueue(false);
}

/**
 * Add job to queue
 * @param {!Object} job Job object
 */
function addJob(job) {
	var abstemp = Math.abs(job.stamp);

	if (abstemp > lastStamp) {
		lastStamp = abstemp;
	}

	var jobEl = places.templateJob.clone();

	jobEl
		.attr( {
			'stamp': abstemp,
			'site': job.site,
			'cats': job.cats.join(',')
		} )
		.hide();

	lnk = $("<a>")
		.addClass(options.siteIconPrefix)
		.addClass(options.siteIconPrefix + '_' + sites[job.site][0])
		.attr({
			'href': '/jobs/' + sites[job.site][1] + '/' + job.id + '.html',
			'title': job.title + ' ' + langVal('on') + ' ' + sites[job.site][2]
		})
		.html(job.title)
		.appendTo($('li.title', jobEl));

	$('li.desc', jobEl).html(job.desc);
	
	var stmp = new Date(abstemp * 1000);
	
	$('li.time', jobEl).html(
		checkTimeVal(stmp.getHours()) + ':' +
		checkTimeVal(stmp.getMinutes())
	);

	var tmpDesc = job.title + ' ' + job.desc;
	tmpDesc = tmpDesc.replace(/&(lt|gt);/g, function(strMatch, p1) {
		return (p1 == 'lt') ? '<' : '>';
	});
	tmpDesc = tmpDesc.replace(/<\/?[^>]+(>|$)/g, '');
	tmpDesc = tmpDesc.toLowerCase();

	$('li.k', jobEl).html(tmpDesc);
	
	var jEl = {
		stamp: job.stamp,
		element: jobEl
	};
	
	queue.push(jEl);
	
	popFromQueue();
}

/**
 * Parse job info
 * @param {!Array} job Job info array
 */
function parseJobs(jobs) {
	for (var i = jobs.length - 1; i >= 0; i--) {
		var job = {
			id:    jobs[i]['i'],
			site:  jobs[i]['s'],
			stamp: jobs[i]['st'],
			title: jobs[i]['t'],
			cats:  jobs[i]['c'],
			desc:  jobs[i]['d']
		};
		
		addJob(job);
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

	var firstStamp = $('ul:last', places.placeJob).attr('stamp');

/* <debug> */
	console.info('update less than ' + firstStamp);
/* </debug> */

	var adata = {};	
	adata[options.elementJobStamp] = -firstStamp;

	$.up({
		data: adata,
		success: function(data) {
			if ('j' in data) {
/* <debug> */
				console.info('New jobs bottom pack: ' + data['j'].length);
/* </debug> */
				parseJobs(data['j']);
			}	
		},
		ping: function() {
			updatingBottom = false;
		}
	});
}

function init() {
	places.logo        = $('#logo');
	places.templateJob = $('ul.job:first');
	places.placeJob    = $('#jobs');
	places.keyword     = $('#keyword');

	finit();
	$settings = new settings();
	$settings.init();

	if ($settings.keywords.length != 0) {
		places.keyword.val($settings.keywords.join(', '));
	}
	
	var adata = {};
	
	adata[options.elementLang]     = getLangVersion();
	adata[options.elementSites]    = getSitesVersion();
	adata[options.elementCats]     = getCatsVersion();
	adata[options.elementJobStamp] = 0;
	
	$.up({
		data: adata,
		success: function(data) {
			$('html, body').css({scrollTop:0});
			
			setNewTimer(options.checkInterval);
	
			if (null == data) 
				return;

			if ('l' in data) {
/* <debug> */
				console.info('New lang pack');
/* </debug> */
				loadLang(data['l']);
			}
			
			if ('c' in data) {
/* <debug> */
				console.info('New categories pack');
/* </debug> */
				loadCats(data['c']);
			}
			
			if ('s' in data) {
/* <debug> */
				console.info('New sites pack');
/* </debug> */
				loadSites(data['s']);
			}
			
			if ('j' in data) {
/* <debug> */
				console.info('New jobs pack: ' + data['j'].length);
/* </debug> */
				parseJobs(data['j']);
			}
		},
		ping: function() {
			$(window).scroll(function() {
				if (
					$(window).scrollTop() >= $(document).height() - $(window).height()
					&& !updatingBottom
				) {
					updateBottom();
				}
			} );
			
			localize();
			initCats();
			initSites();
		}
	});
		
	$('#bfoot, .help, #menu').css({'opacity': 0.8});

	places.buttonPlay  = $('#play');
	places.buttonPause = $('#pause');
	
	places.buttonPause.click(streamPause);
	places.buttonPlay.click(streamPlay);
	
	places.logo.ajaxStart(function() {
		$(this).animate({'opacity': 0.7}, options.animationSpeed);
	});
	
	places.logo.ajaxStop(function() {
		$(this).animate({'opacity': 1});
	});

	setQueueTimer(5000);
	
	// removing right content
	$('#right ul').remove();
	
	$('#help').click(function() {
		$('.help').animate({'opacity': 'toggle', 'height': 'toggle'}, options.animationSpeed);
		
		if (!helpVisible) {
			$('html, body').animate({'scrollTop':0}, 'slow');
		}
		
		helpVisible = !helpVisible;
	});
	
	places.keyword
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

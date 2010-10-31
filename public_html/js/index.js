/** @type {number} **/ var lastStamp = 0;
/** @type {number} **/ var updateCount = 0;

var newTimer;

/** @type {Boolean} **/ var updating = false;
/** @type {Boolean} **/ var updatingBottom = false;

/** @type {Boolean} **/ var helpVisible = false;
/** @type {number} **/  var lastBottom = 0;
/** @type {Boolean} **/ var paused = false;

/** @type {Array} **/ var joblist  = [];
/** @type {Array} **/ var money = ['%d р.', '$%d'];

var places = {
	/** @type {jQuery} **/ templateJob: null,
	/** @type {jQuery} **/ placeJob:    null,
	/** @type {jQuery} **/ buttonPlay:  null,
	/** @type {jQuery} **/ buttonPause: null,
	/** @type {jQuery} **/ logo:        null,
	/** @type {jQuery} **/ filterMode:  null
}

var options = {
	/** @type {number} **/  defJobPageCount: 30,
	/** @type {number} **/  maxJobPageCount: 30,
	/** @const **/ maxTitleLength:           75,
	/** @const **/ checkInterval:            40000,
	/** @const **/ checkIntervalFiltered:    60000,
	
	/** @const **/ siteIconPrefix:           'sico',
	/** @const **/ animationSpeed:           'slow',
	
	/** @const **/ classSelected:            'jsel',
	/** @const **/ classNotSelected:         'jrem',
	
	/** @const **/ elementSites:             'sites',
	/** @const **/ elementLang:              'lang',
	/** @const **/ elementCats:              'cats',
	/** @const **/ elementJobStamp:          'jstamp',
	/** @const **/ elementFilter:            'filter'
}

// ---------------------------------------------------
// Base objects
// ---------------------------------------------------

/**
 * @type {workbreeze.storage}
 */
var storage = new workbreeze.storage();

/**
 * @type {workbreeze.settings}
 */
var settings = new workbreeze.settings();

/**
 * @type {workbreeze.locale}
 */
var locale = new workbreeze.locale(storage, {
	storagePath: options.elementLang
} );

/**
 * @type {workbreeze.categories}
 */
var categories = new workbreeze.categories(storage, locale, {
	place: '#categories'
} );

/**
 * @type {workbreeze.sites}
 */
var sites = new workbreeze.sites(storage, {
	iconPrefix: options.siteIconPrefix
} );

/**
 * @type {workbreeze.keywords}
 */
var keywords = new workbreeze.keywords( {
	place: '#keywords'
} );

/**
 * @type {workbreeze.filter}
 */
var filter = new workbreeze.filter(storage);

filter.add(sites);
filter.add(categories);
filter.add(keywords);

/**
 * Ajax /up caller
 * @param {Object} s Settings
 */
function up(s) {
	if (updating) {
		// see ya next time
		setTimeout(function() {
			up(s);
		}, 30000)
		
		return;
	}

	updating = true;

	$.ajax({
		url: '/up',
		type: 'POST',
		data: s.data,
		dataType: 'json',
		cache: false,
		success: function(data) {
			updating = false;
		
			if (s.success) {
				s.success(data);
			}
			
			if (s.ping) {
				s.ping();
			}
		},
		error: function(request, status, error) {
			updating = false;
			
			if (s.error) {
				s.error();
			}
			
			if (s.ping) {
				s.ping();
			}
		}
	});
}

function checkJobPlace() {
	while (joblist.length > options.maxJobPageCount) {
/* <debug> */
		console.info('Removing last job');
/* </debug> */
	
		var tmpEl = joblist.shift();
		tmpEl.fadeOut(options.animationSpeed, function() { 
			$(this).remove();
		});
	}
}

/**
 * Prepare a query for new jobs request
 * @param {!number} stamp
 * @return {Object} Params
 */
function prepareDataForJobs(stamp) {
	var adata = {};	
	adata[options.elementJobStamp] = stamp;

	if (settings.filterMode) {
		if (sites.count() != settings.sites.length) {
			adata[options.elementFilter + '_' + options.elementSites] = settings.sites.join(',');
		}
		
		if (categories.count() != settings.categories.length) {
			adata[options.elementFilter + '_' + options.elementCats] = settings.categories.join(',');
		}
		
		if (settings.keywords.length > 0) {
			adata[options.elementFilter + '_' + options.elementKeywords] = settings.keywords.join(',');
		}
	}

	return adata;
}

function checkNewJobs() {
	var adata = prepareDataForJobs(lastStamp);

	up( {
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
		
			setNewTimer(settings.filterMode ? options.checkIntervalFiltered : options.checkInterval);
		},
		error: function() {
			setNewTimer(options.checkInterval * 2);
		}
	} );
}

function dropNewTimer() {
	if (null != newTimer) {
		clearTimeout(newTimer);
	}
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
 * Add job to feed
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
		// set new jobs a little offset
		.css( {
			'margin-left': '-10px'
		} );

	var htmltitle = job.title;

	if (job.title.length > options.maxTitleLength) {
		var tmpindex = job.title.substring(0, options.maxTitleLength).lastIndexOf(' ');

		if (tmpindex < 0) {
			tmpindex = options.maxTitleLength;
		}

		htmltitle = job.title.substring(0, tmpindex) + '...';
	}
	
	var site = sites.get(job.site);

	var lnk = $("<a>")
		.addClass(options.siteIconPrefix)
		.addClass(options.siteIconPrefix + '_' + site[0])
		.attr({
			'href': '/jobs/' + site[1] + '/' + job.id + '.html',
			'title': job.title + ' ' + locale.translate('on') + ' ' + site[2]
		})
		.html(htmltitle)
		.appendTo($('li.title', jobEl));

	$('li.desc', jobEl).html(job.desc);
	
	var stmp = new Date(abstemp * 1000);
	
	$('li.time', jobEl).html(locale.timeString(stmp));

	if (undefined != job.money) {
		var fmt = money[job.currency];
	
		$('li.money', jobEl).html(fmt.replace('%d', job.money));
	}

	var tmpDesc = job.title + ' ' + job.desc;
	tmpDesc = tmpDesc.replace(/&(lt|gt);/g, function(strMatch, p1) {
		return (p1 == 'lt') ? '<' : '>';
	});
	tmpDesc = tmpDesc.replace(/<\/?[^>]+(>|$)/g, '');
	tmpDesc = tmpDesc.toLowerCase();

	$('li.k', jobEl).html(tmpDesc);
	
	var tmpJob = {
		stamp: job.stamp,
		element: jobEl
	};

	joblist.push(jobEl);
		
	if (job.stamp < 0) {
		jobEl.appendTo(places.placeJob);
		
		options.maxJobPageCount++;
	} else {
		if (
			$(window).scrollTop() == 0
			&& options.maxJobPageCount - 2 >= options.defJobPageCount
		) {		
			options.maxJobPageCount = options.maxJobPageCount - 2;
		}
	
		jobEl.prependTo(places.placeJob);
	}

	// make job normal
	setTimeout( function() {
		jobEl.animate( {
			'margin-left': '0px'
		}, options.animationSpeed );
	}, 30000 );
	
	if (!settings.filterMode) {
		checkJobForFilter(jobEl);
	}

	checkJobPlace();	
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

		if ('m' in jobs[i]) {
			job.money = jobs[i]['m'][0];
			job.currency = jobs[i]['m'][1];
		}
		
		addJob(job);
	}
}

function streamToggle() {
	if (paused) {
		streamPlay();
	} else {
		streamPause();
	}
}

function streamPause() {
	places.buttonPause.slideUp(options.animationSpeed);
	places.buttonPlay.slideDown(options.animationSpeed);

	dropNewTimer();

	paused = true;
}

function streamPlay() {
	if (
		0 == settings.sites.length
		|| 0 == settings.categories.length
	) {
		return;
	}

	streamAutoPause = false;
	paused = false;

	places.buttonPlay.slideUp(options.animationSpeed);
	places.buttonPause.slideDown(options.animationSpeed);

	lastStamp = Math.round(new Date().getTime() / 1000);
	setNewTimer(5000);
}

function updateBottom() {
	var firstStamp = $('ul:last', places.placeJob).attr('stamp');
	
	if (lastBottom == firstStamp) {
		return;
	} else {
		lastBottom = firstStamp;
	}

	updatingBottom = true;

	dropNewTimer();

/* <debug> */
	console.info('update less than ' + firstStamp);
/* </debug> */

	var adata = prepareDataForJobs(-firstStamp);

	up({
		data: adata,
		success: function(data) {
			if (null === data) {
				return;
			}
			
			if ('j' in data) {
				parseJobs(data['j']);
			}	
		},
		ping: function() {
			updatingBottom = false;

			setNewTimer(settings.filterMode ? options.checkIntervalFiltered : options.checkInterval);
		}
	});
}

function init() {
	places.buttonPlay  = $('#play');
	places.buttonPause = $('#pause');
	
	places.buttonPause.click(streamToggle);
	places.buttonPlay.click(streamToggle);
	
	filter.init();
		
	places.filterMode.click(function() {
		settings.toggleFilterMode();
		settings.save();
		places.filterMode.toggleClass('checked');		
	});
}

// ---------------------------------------------------
// Preparements
// ---------------------------------------------------
places.logo        = $('#logo');
places.templateJob = $('ul.job:first');
places.placeJob    = $('#jobs');
places.filterMode  = $('#mode_f');

if (settings.keywords.length != 0) {
	places.keyword.val(settings.keywords.join(', '));
}

if (settings.filterMode) {
	places.filterMode.toggleClass('checked');
}
	
places.logo.ajaxStart(function() {
	$(this).animate({'opacity': 0.7}, options.animationSpeed);
});

places.logo.ajaxStop(function() {
	$(this).animate({'opacity': 1});
});

$('#bfoot, .help, #menu').css({'opacity': 0.8});
$('#right ul').remove();

// ---------------------------------------------------
// Initial data request
// ---------------------------------------------------	

var adata = prepareDataForJobs(0);

adata[options.elementLang]  = locale.getLocalVersion();
adata[options.elementSites] = sites.getLocalVersion();
adata[options.elementCats]  = categories.getLocalVersion();

up({
	data: adata,
	success: function(data) {
		// settings the next check timer
		setNewTimer(options.checkInterval);
	
		// scrolling to the top
		$('html, body').css({scrollTop:0});

		if (null == data) 
			return;

		if ('l' in data) {
			locale.load(data['l']);
		}
		
		if ('c' in data) {
			categories.load(data['c']);
		}
		
		if ('s' in data) {
			sites.load(data['s']);
		}
		
		if ('j' in data) {
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
		
		// @todo localize just needed parts
		locale.localize();
		categories.init();
		sites.init();
		
		init();
	}
});

// ---------------------------------------------------
// Secondary things to do
// ---------------------------------------------------
$('#help').click(function() {
	$('.help').animate({'opacity': 'toggle', 'height': 'toggle'}, options.animationSpeed);
	
	if (!helpVisible) {
		$('html, body').animate({'scrollTop':0}, options.animationSpeed);
	}
	
	helpVisible = !helpVisible;
});

/**
 * @constructor
 * @this {Workbreeze.Feed}
 * @param {Object} s Options.
 */
Workbreeze.Feed = function(s) {
	var self = this;

	/** @type {number} **/ var lastStamp = 0;

	var newTimer;

	/** @type {boolean} **/ var updating = false;
	/** @type {boolean} **/ var updatingBottom = false;

	/** @type {boolean} **/ var helpVisible = false;
	/** @type {number} **/  var lastBottom = 0;
	/** @type {boolean} **/ var paused = false;
	/** @type {boolean} **/ var streamAutoPaused = false;

	/** @type {Array} **/ var joblist  = [];
	/** @type {Array} **/ var money = ['%d р.', '$%d'];

	var places = {
		/** @type {jQueryObject} **/ templateJob: null,
		/** @type {jQueryObject} **/ placeJob:    null,
		/** @type {jQueryObject} **/ buttonPlay:  null,
		/** @type {jQueryObject} **/ buttonPause: null,
		/** @type {jQueryObject} **/ logo:        null
	};

	var options = $.extend( {
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
	}, s);

	// ---------------------------------------------------
	// Base objects
	// ---------------------------------------------------

	/**
	 * @type {Workbreeze.Storage}
	 */
	var storage = new Workbreeze.Storage();

	/**
	 * @type {Workbreeze.Locale}
	 */
	var locale = new Workbreeze.Locale(storage, {
		storagePath: options.elementLang
	} );

	/**
	 * @type {Workbreeze.Categories}
	 */
	var categories = new Workbreeze.Categories(storage, locale, {
		place: '#categories'
	} );

	/**
	 * @type {Workbreeze.Sites}
	 */
	var sites = new Workbreeze.Sites(storage, {
		iconPrefix: options.siteIconPrefix
	} );

	/**
	 * @type {Workbreeze.Keywords}
	 */
	var keywords = new Workbreeze.Keywords( {
		place: '#keywords'
	} );

	/**
	 * @type {Workbreeze.Filter}
	 */
	var filter = new Workbreeze.Filter(storage, {
		onChanged: function(isEmpty) {
			if (isEmpty) {
				if (!paused) {
					streamAutoPaused = true;
				}

				streamPause();
			} else {
				if (streamAutoPaused) {
					streamPlay();
				}
			}
		
			checkJobs();
		}
	} );

	filter.add(sites);
	filter.add(categories);
	filter.add(keywords);

	/**
	 * Ajax /up caller
	 * @param {Object} s Settings.
	 */
	var up = function(s) {
		if (updating) {
			// see ya next time
			setTimeout(function() {
				up(s);
			}, 30000);
		
			return;
		}

		updating = true;

		$.ajax({
			'url': '/up',
			'type': 'POST',
			'data': s.data,
			'dataType': 'json',
			'cache': false,
			'success': function(data) {
				updating = false;
	
				if (s.success) {
					s.success(data);
				}
			
				if (s.ping) {
					s.ping();
				}
			},
			'error': function(request, status, error) {
				updating = false;
			
				if (s.error) {
					s.error();
				}
				
				if (s.ping) {
					s.ping();
				}
			}
		});
	};

	/**
	 * Check the job place
	 */
	var checkJobPlace = function() {
		while (joblist.length > options.maxJobPageCount) {
			/* <debug> */
			console.info('Removing last job');
			/* </debug> */
	
			var tmpEl = joblist.shift();
			tmpEl.fadeOut(options.animationSpeed, function() { 
				$(this).remove();
			});
		}
	};

	/**
	 * Prepare a query for new jobs request
	 * @param {!number} stamp Unix timestamp.
	 * @return {Object} Params.
	 */
	var prepareDataForJobs = function(stamp) {
		var adata = {};	

		if (filter.getFilterMode()) {
			adata = filter.getCriteriaData();
		}

		adata[options.elementJobStamp] = stamp;

		return adata;
	};

	/**
	 * Check for new jobs
	 */
	var checkNewJobs = function() {
		var adata = prepareDataForJobs(lastStamp);

		up( {
			data: adata,
			success: function(data) {
				if (null === data) {
					return;
				}
		
				if ('j' in data) {
					/* <debug> */
					console.info('New jobs pack: ' + data['j'].length);
					/* </debug> */

					parseJobs(data['j']);
				}
		
				setNewTimer(filter.getFilterMode() ? options.checkIntervalFiltered : options.checkInterval);
			},
			error: function() {
				setNewTimer(options.checkInterval * 2);
			}
		} );
	};

	/**
	 * Drop the new job checker timer
	 * TODO do something with it
	 */
	var dropNewTimer = function() {
		if (null != newTimer) {
			clearTimeout(newTimer);
		}
	};

	/**
	 * Sets the new jobs checker timer
	 * @param {!number} interval Interval.
	 */
	var setNewTimer = function(interval) {
		dropNewTimer();
		newTimer = setInterval(checkNewJobs, interval);
	};

	/**
	 * Add job to feed
	 * @param {!Object} job Job object.
	 */
	var addJob = function(job) {
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
	
		if (!filter.getFilterMode()) {
			checkJob(jobEl);
		}

		checkJobPlace();	
	};

	/**
	 * Function to check all jobs in the feed
	 */
	var checkJobs = function() {
		for (var i = 0; i < joblist.length; i++) {
			checkJob(joblist[i]);
		}
	};

	/**
	 * Check job element
	 * @param {jQueryObject} jobElement Job element.
	 */
	var checkJob = function(jobElement) {
		if (filter.checkJob(jobElement)) {
			if (
				!jobElement.hasClass(options.classSelected)
				|| jobElement.hasClass(options.classNotSelected)
			) {
				jobElement
					.removeClass(options.classNotSelected)
					.addClass(options.classSelected);
		
				jobElement.animate( {
					'opacity': 1
				} );
			}
		} else {
			if (
				!jobElement.hasClass(options.classNotSelected)
				|| jobElement.hasClass(options.classSelected)
			) {
				jobElement
					.removeClass(options.classSelected)
					.addClass(options.classNotSelected);
		
				jobElement.animate( {
					'opacity': 0.2
				} );
			}
		}
	}

	/**
	 * Parse job info
	 * @param {!Array} jobs Job info array.
	 */
	var parseJobs = function(jobs) {
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

	/**
	 * Toggle the stream state
	 */
	var streamToggle = function() {
		if (paused) {
			streamPlay();
		} else {
			streamPause();
		}
	}

	/**
	 * Pause the stream
	 */
	var streamPause = function() {
		places.buttonPause.slideUp(options.animationSpeed);
		places.buttonPlay.slideDown(options.animationSpeed);

		dropNewTimer();

		paused = true;
	}

	/**
	 * Play the stream
	 */
	var streamPlay = function() {
		streamAutoPaused = false;
		paused = false;

		places.buttonPlay.slideUp(options.animationSpeed);
		places.buttonPause.slideDown(options.animationSpeed);

		lastStamp = Math.round(new Date().getTime() / 1000);
		setNewTimer(5000);
	}

	/**
	 * Update feed from the bottom
	 */
	var updateBottom = function() {
		var firstStamp = parseInt($('ul:last', places.placeJob).attr('stamp'), 10);
	
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

				setNewTimer(filter.getFilterMode() ? options.checkIntervalFiltered : options.checkInterval);
			}
		});
	}

	/** @type {boolean} **/ var initialized = false;

	/**
	 * Initialization
	 */
	var init = function() {
		if (initialized) {
			return;
		} else {
			initialized = true;
		}

		places.buttonPlay  = $('#play');
		places.buttonPause = $('#pause');
	
		places.buttonPause.click(streamToggle);
		places.buttonPlay.click(streamToggle);

		// @todo localize just needed parts
		locale.localize();
		categories.init();
		sites.init();

		filter.init();

		var filterModePlace = $('#mode_f');

		if (filter.getFilterMode()) {
			filterModePlace.addClass('checked');
		}
		
		filterModePlace.click(function() {
			filter.setFilterMode(!filter.getFilterMode());

			filterModePlace.toggleClass('checked');		
		});

		setNewTimer(options.checkInterval);
	}

	// ---------------------------------------------------
	// Preparements
	// ---------------------------------------------------
	places.logo        = $('#logo');
	places.templateJob = $('ul.job:first');
	places.placeJob    = $('#jobs');

	places.logo.ajaxStart(function() {
		$(this).animate({'opacity': 0.7}, options.animationSpeed);
	});

	places.logo.ajaxStop(function() {
		$(this).animate({'opacity': 1});
	});

	$('#bfoot, .help, #menu').css({'opacity': 0.8});
	$('#right ul').remove();

	// ---------------------------------------------------
	// Initial data request for accessorial data
	// ---------------------------------------------------	

	var adata = prepareDataForJobs(0);

	adata[options.elementLang]  = locale.getLocalVersion();
	adata[options.elementSites] = sites.getLocalVersion();
	adata[options.elementCats]  = categories.getLocalVersion();

	up({
		data: adata,
		success: function(data) {
			// setting the next check timer
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

			init();

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
		
			// init anyway
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
}

/**
 * @type {Workbreeze.Feed}
 */
var feed = new Workbreeze.Feed({});

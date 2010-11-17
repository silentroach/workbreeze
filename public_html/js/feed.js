/**
 * @constructor
 * @this {Workbreeze.Feed}
 * @param {Object} s Options.
 */
Workbreeze.Feed = function(s) {
	var self = this;

	/** @type {number} **/ var lastStamp = 0;

	/** @type {boolean} **/ var updating = false;
	/** @type {boolean} **/ var updatingBottom = false;

	/** @type {number} **/  var lastBottom = 0;
	/** @type {boolean} **/ var paused = false;
	/** @type {boolean} **/ var streamAutoPaused = false;

	/** @type {Array} **/ var joblist  = [];
	/** @type {Array} **/ var money = ['%d р.', '$%d'];

	/** @type {jQueryObject} **/ var jobsContainer = $('#jobs');
	/** @type {jQueryObject} **/ var jobTemplate   = $('ul.job:first');

	// TODO remove this object
	var places = {
		/** @type {jQueryObject} **/ buttonPlay:  null,
		/** @type {jQueryObject} **/ buttonPause: null
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
	 * @type {Workbreeze.Notifier}
	 */
	var notifier = new Workbreeze.Notifier( {
		onData: function(data) {
			if ('j' in data) {
				parseJobs(data['j']);
			}
			
			// start the notifier			
			notifier.setParams(prepareDataForJobs(lastStamp));
		}
	} );

	/**
	 * @type {Workbreeze.Filter}
	 */
	var filter = new Workbreeze.Filter(storage, {
		onChanged: function(isEmpty) {
			notifier.setParams(prepareDataForJobs(lastStamp));
		
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
	 * Check the job place
	 */
	var checkJobPlace = function() {
		while (joblist.length > options.maxJobPageCount) {
			/* <debug> */
			console.info('Removing last job');
			/* </debug> */
	
			/** @type {jQueryObject} */ var $tmpEl = joblist.shift();
			$tmpEl.fadeOut(options.animationSpeed, function() { 
				$(this).remove();
			} );
		}
	};

	/**
	 * Prepare a query for new jobs request
	 * @param {!number} stamp Unix timestamp.
	 * @return {Object} Params.
	 */
	var prepareDataForJobs = function(stamp) {
		var adata = new Workbreeze.NotifierParams();

		if (filter.getFilterMode()) {
			adata.params = filter.getCriteriaData();
		}

		adata.ajaxOnly[options.elementJobStamp] = stamp;

		return adata;
	};
	// -- highlights
	
	/**
	 * Timer for highlights
	 */
	var highlightTimer;

	/**
	 * Hightlight job sites and categories
	 * @param {jQueryObject} $job Job element.
	 */
	var highlightJob = function($job) {
		if (null !== highlightTimer) {
			clearTimeout(highlightTimer);
		}

		categories.highlightJob($job);
	};

	/**
	 * Clear highlights
	 */
	var clearHighlight = function() {
		highlightTimer = setTimeout( function() {
			categories.clearHighlight();
		}, 300);
	};
	// -- /highlights

	/**
	 * Add job to feed
	 * @param {!Object} job Job object.
	 */
	var addJob = function(job) {
		var abstemp = Math.abs(job.stamp);

		if (abstemp > lastStamp) {
			lastStamp = abstemp;
		}

		// new html element for job
		var $jobEl = jobTemplate.clone();

		$jobEl
			.attr( {
				'stamp': abstemp,
				'site': job.site,
				'cats': job.cats.join(',')
			} )
			// set new jobs a little offset
			.css( {
				'margin-left': '-10px'
			} );

		// cut the title if it is too big
		var htmltitle = job.title;

		if (job.title.length > options.maxTitleLength) {
			var tmpindex = job.title.substring(0, options.maxTitleLength).lastIndexOf(' ');

			if (tmpindex < 0) {
				tmpindex = options.maxTitleLength;
			}

			htmltitle = job.title.substring(0, tmpindex) + '...';
		}
	
		// getting the site information for job
		var site = sites.get(job.site);

		var lnk = $("<a>")
			.addClass(options.siteIconPrefix)
			.addClass(options.siteIconPrefix + '_' + site[0])
			.attr({
				'href': '/jobs/' + site[1] + '/' + job.id + '.html',
				'title': job.title + ' ' + locale.translate('on') + ' ' + site[2]
			})
			.html(htmltitle)
			.appendTo( $('li.title', $jobEl) );

		$('li.desc', $jobEl).html(job.desc);
	
		// adding humanized timestamp
		var stmp = new Date(abstemp * 1000);
	
		$('li.time', $jobEl).html(locale.timeString(stmp));

		// and budget value if it is exists
		if (undefined != job.money) {
			var fmt = money[job.currency];
	
			$('li.money', $jobEl).html(fmt.replace('%d', job.money));
		}

		// preparing the description to search by keywords
		var tmpDesc = job.title + ' ' + job.desc;
		tmpDesc = tmpDesc.replace(/&(lt|gt);/g, function(strMatch, p1) {
			return (p1 == 'lt') ? '<' : '>';
		});
		tmpDesc = tmpDesc.replace(/<\/?[^>]+(>|$)/g, '');
		tmpDesc = tmpDesc.toLowerCase();

		$('li.k', $jobEl).html(tmpDesc);
	
		// adding element to global job array
		joblist.push( $jobEl );
		
		if (job.stamp < 0) {
			// add job to the bottom (stamp is below zero)
			$jobEl.appendTo(jobsContainer);
		
			options.maxJobPageCount++;
		} else {
			// decreasing job count on a page if we are on top
			// and limit overhead is detected
			if (
				$(window).scrollTop() == 0
				&& options.maxJobPageCount - 2 >= options.defJobPageCount
			) {		
				options.maxJobPageCount = options.maxJobPageCount - 2;
			}
	
			// append to the top
			$jobEl.prependTo(jobsContainer);
		}

		// make job normal width after 30 seconds
		setTimeout( function() {
			$jobEl.animate( {
				'margin-left': '0px'
			}, options.animationSpeed );
		}, 30000 );
	
		// checking the job if filter mode is turned off
		if (!filter.getFilterMode()) {
			checkJob( $jobEl );
		}

		// setup highlights on mouseover
		$jobEl
			.mouseenter( function(e) {
				highlightJob(jobEl);
			} )
			.mouseleave(clearHighlight);

		// check all the job feed on the screen
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
	};

	/**
	 * Parse job info
	 * @param {!Array} jobs Job info array.
	 */
	var parseJobs = function(jobs) {
		$(jobs).each( function() {
			var job = {
				id:    this['i'],
				site:  this['s'],
				stamp: this['st'],
				title: this['t'],
				cats:  this['c'],
				desc:  this['d']
			};

			if ('m' in this) {
				job.money = this['m'][0];
				job.currency = this['m'][1];
			}
		
			addJob(job);
		} );
	};

	/**
	 * Toggle the stream state
	 */
	var streamToggle = function() {
		if (paused) {
			streamPlay();
		} else {
			streamPause();
		}
	};

	/**
	 * Pause the stream
	 */
	var streamPause = function() {
		places.buttonPause.slideUp(options.animationSpeed);
		places.buttonPlay.slideDown(options.animationSpeed);

		notifier.stop();

		paused = true;
	};

	/**
	 * Play the stream
	 */
	var streamPlay = function() {
		streamAutoPaused = false;
		paused = false;

		places.buttonPlay.slideUp(options.animationSpeed);
		places.buttonPause.slideDown(options.animationSpeed);

		lastStamp = Math.round(new Date().getTime() / 1000);

		notifier.start();
	};

	/**
	 * Update feed from the bottom
	 */
	var updateBottom = function() {
		var firstStamp = parseInt($('ul:last', jobsContainer).attr('stamp'), 10);
	
		if (lastBottom == firstStamp) {
			return;
		} else {
			lastBottom = firstStamp;
		}

		updatingBottom = true;

		/* <debug> */
		console.info('update less than ' + firstStamp);
		/* </debug> */

		var adata = prepareDataForJobs(-firstStamp);

		Workbreeze.Ajax( {
			data: $.extend(adata.params, adata.ajaxOnly),
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
			}
		} );
	};

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
		locale.setTrigger('#lang');

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
		
		var adata = prepareDataForJobs(0);
		
		Workbreeze.Ajax( {
			data: $.extend(adata.params, adata.ajaxOnly),
			success: function(data) {
				if (
					null !== data
					&& 'j' in data
				) {
					parseJobs(data['j']);
				}
			},
			ping: function() {
				// start the notifier			
				notifier.setParams(prepareDataForJobs(lastStamp));
			}		
		} );		
	};

	// some visual preparements
	//
	$('#right ul').remove();
	$('#bfoot, .help, #menu li').css({'opacity': 0.7});

	// animation for logo when ajax is used

	$('#logo')
		.ajaxStart(function() {
			$(this).animate( {
				'opacity': 0.7
			}, options.animationSpeed);
		})
		.ajaxStop(function() {
			$(this).animate( {
				'opacity': 1
			}, options.animationSpeed);
		});

	// Initial data request for accessorial data

	var adata = {};

	adata[options.elementLang]  = locale.getLocalVersion();
	adata[options.elementSites] = sites.getLocalVersion();
	adata[options.elementCats]  = categories.getLocalVersion();

	Workbreeze.Ajax( {
		data: adata,
		success: function(data) {
			if (null == data) 
				return;

			// scroll to the top if any
			$('html, body').css('scrollTop', 0);

			if ('l' in data) {
				locale.load(data['l']);
			}
		
			if ('c' in data) {
				categories.load(data['c']);
			}
		
			if ('s' in data) {
				sites.load(data['s']);
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
		
			// initialize even if it is failed
			init();
		}
	});

	// Initialize help marks

	/** 
	 * @type {boolean} 
	 */
	var helpVisible = false;

	$('#help').click( function() {
		var $self = $(this);

		$('.help').animate( {
			'opacity' : 'toggle', 
			'height'  : 'toggle'
		}, options.animationSpeed);
	
		if (!helpVisible) {
			$('html, body').animate( {
				'scrollTop' : 0
			}, options.animationSpeed);

			$self.css('opacity', 1);
		} else {
			$self.css('opacity', .7);
		}
	
		helpVisible = !helpVisible;
	} );
};

/**
 * @type {Workbreeze.Feed}
 */
var feed = new Workbreeze.Feed({});

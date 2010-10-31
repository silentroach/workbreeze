/**
 * Filter
 * @constructor
 * @this {workbreeze.filter}
 * @param {Object} s Options
 */
workbreeze.filter = function(storage, s) {
	var self = this;
	
	/**
	 * Options
	 * @type {Object}
	 */
	var options = $.extend( {

	}, s);
	
	/**
	 * Array of filter items
	 * @type {Array}
	 */
	var filterItems = [];
	
	/**
	 * Filter criteria
	 * @type {Array}
	 */
	var criteria = {};
	
	/**
	 * Item changed filter
	 * @param {Object} item Filter item
	 */
	var handleItemChanged = function(item) {
		criteria[item.identifier] = item.getValue();

		storage.set('opts', criteria);
	}
	
	/**
	 * Add item to filter by
	 * @param {Object} item Filter item
	 */
	self.add = function(item) {
		item.onChanged = function() {
			handleItemChanged(item);
		}
	
		filterItems.push(item);
	}
	
	/**
	 * Initialization
	 */
	self.init = function() {
		criteria = storage.get('opts') || {};
		
		$(filterItems).each( function() {
			if (this.identifier in criteria) {
				this.setValue(criteria[this.identifier]);
			}
		} );
	}
	
}



/** @type {Boolean} **/ var streamAutoPause = false;

function handleFilter() {
	settings.clearSites();
	settings.clearCategories();
	settings.clearKeywords();

	$('li', '#sites').each( function() {
		var el = $(this);

		if (el.hasClass('checked')) {
			settings.addSite(el.attr('site'));
		}
	} );

	$('li', '#categories').each( function() {
		var el = $(this);
	
		if (el.hasClass('checked')) {
			settings.addCat(el.attr('cat'));
		}
	} );

	if (
		0 == settings.sites.length
		|| 0 == settings.categories.length
	) {
		if (!paused) {
			streamAutoPause = true;
			streamPause();
		}
	} else if (streamAutoPause) {
		streamAutoPause = false;
		streamPlay();
	}

	settings.save();

	if (!settings.filterMode) {
		checkFeedForFilter();
	}
}

function jobSelectAll() {
	for (var i in joblist) {
		jobSelect(joblist[i]);
	}
}

/**
 * @param {jQuery} element
 */
function jobSelect(element) {
	if (
		!element.hasClass(options.classSelected)
		|| element.hasClass(options.classNotSelected)
	) {
		element
			.removeClass(options.classNotSelected)
			.addClass(options.classSelected);
		
		element.animate( {
			'opacity': 1
		} );
	}
}

/**
 * @param {jQuery} element
 */
function jobUnselect(element) {
	if (
		!element.hasClass(options.classNotSelected)
		|| element.hasClass(options.classSelected)
	) {
		element
			.removeClass(options.classSelected)
			.addClass(options.classNotSelected);
		
		element.animate( {
			'opacity': 0.2
		} );
	}
}

/**
 * @param {jQuery} element
 */
function checkJobForFilter(element) {
	if (
		0 == settings.sites.length
		|| 0 == settings.categories.length
	) {
		jobSelect(element);
		return;
	}

	var str = $('li.k', element).html();
	
	var wrong = $.inArray(element.attr('site'), settings.sites) < 0;
	
	if (!wrong) {
		var cts = element.attr('cats').split(',');

		var cwrong = true;
	
		for (var i = 0; i < cts.length; i++) {
			if ($.inArray(cts[i], settings.categories) >= 0) {
				cwrong = false;
				break;
			}
		}
		
		if (cwrong) {
			wrong = true;
		}
	}

	if (
		!wrong
		&& 0 != settings.keywords.length
	) {
		wrong = true;
	
		for (var i = 0; i < settings.keywords.length; i++) {
			if (str.indexOf(settings.keywords[i].toLowerCase()) >= 0) {
				wrong = false;
				break;
			}
		}
	}
	
	if (!wrong) {
		jobSelect(element);
	} else {
		jobUnselect(element);
	}
}

function checkFeedForFilter() {	
	for (var i = 0; i < joblist.length; i++) {
		checkJobForFilter(joblist[i]);
	}
}

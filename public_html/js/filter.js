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
		onChanged: function() { }
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

		options.onChanged();
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

	/**
	 * Check job element for criteria by filter items
	 * @param {jQuery} jobElement Job element
	 */
	self.checkJob = function(jobElement) {
		var result = true;

		for (var i = 0; i < filterItems.length; i++) {
			if (!filterItems[i].checkJob(jobElement)) {
				result = false;
				break;
			}
		}

		return result;
	}

}



/** @type {Boolean} **/ var streamAutoPause = false;

function handleFilter() {
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

function checkFeedForFilter() {	
	for (var i = 0; i < joblist.length; i++) {
		checkJobForFilter(joblist[i]);
	}
}

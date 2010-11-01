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
		onChanged: function(criteriaIsEmpty) { }
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
	 * Filter mode
	 * @param {boolean}
	 */
	var filterMode = false;

	var postItemChanged = function() {
		storage.set('opts', criteria);

		var isEmpty = false;

		for (var key in criteria) {
			if (
				key != 'keys'     // @todo fix this shit
				&& $.isArray(criteria[key])
				&& criteria[key].length === 0
			) {
				isEmpty = true;
				break;
			}
		}

		options.onChanged(isEmpty);
	}

	/**
	 * Item changed filter
	 * @param {Object} item Filter item
	 */
	var handleItemChanged = function(item) {
		criteria[item.identifier] = item.getValue();

		postItemChanged();
	}

	/**
	 * Set filter mode
	 * @param {boolean} fm Filter mode
	 */
	self.setFilterMode = function(fm) {
		filterMode = fm;

		criteria['fm'] = fm;

		postItemChanged();
	}

	/**
	 * Get filter mode
	 * @return {boolean} Filter mode
	 */
	self.getFilterMode = function() {
		return filterMode;
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
	 * Get the criteria for /up
	 * @return {Object}
	 */
	self.getCriteriaData = function() {
		var out = {};

		for (var key in criteria) {
			if (
				'fm' != key        // skipping filter mode
				&& criteria[key].length > 0
			) {
				out['filter_' + key] = criteria[key].join(',');
			}
		}

		return out;
	}

	/**
	 * Initialization
	 */
	self.init = function() {
		criteria = storage.get('opts') || {};

		if (
			'fm' in criteria
			&& criteria['fm']
		) {
			filterMode = true;
		}

		$(filterItems).each( function() {
			if (criteria.length === 0) {
				this.selectAll();
			} else
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

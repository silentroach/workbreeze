/**
 * Settings
 * @constructor
 */
workbreeze.settings = function() {
	var self = this;

	/**
	 * Settings storage name
	 * @type {string}
	 * @private
	 * @const
	 */
	var lsname = 'settings';

	/**
	 * Sites element name
	 * @type {string}
	 * @private
	 * @const
	 */
	var psites = 'sites';

	/**
	 * Categories element name
	 * @type {string}
	 * @private
	 * @const
	 */
	var pcats  = 'cats';

	/**
	 * Keywords element name
	 * @type {string}
	 * @private
	 * @const
	 */
	var pkeys  = 'keys';
	
	/**
	 * Filter mode element name
	 * @type {Boolean}
	 * @private
	 * @const
	 */
	var pfiltermode = 'fmode';

	/** @type {Array} **/   self.keywords   = [];
	/** @type {Array} **/   self.sites      = [];
	/** @type {Array} **/   self.categories = [];
	/** @type {Boolean} **/ self.filterMode = false;

	self.load = function() {
		var obj = storage.get(lsname);

		if (!obj) {
			return;
		}

		if (psites in obj) {
			self.sites = obj[psites];
		}

		if (pcats in obj) {
			self.categories = obj[pcats];
		}

		if (pkeys in obj) {
			self.keywords = obj[pkeys];
		}
		
		if (pfiltermode in obj) {
			self.filterMode = obj[pfiltermode];
		}
	};

	self.save = function() {
		var obj = {};
		obj[psites]      = self.sites;
		obj[pcats]       = self.categories;
		obj[pkeys]       = self.keywords;
		obj[pfiltermode] = self.filterMode;

		storage.set(lsname, obj);
	};

	/**
	 * Add site to selected
	 * @param {!number} site Site id
	 */
	self.addSite = function(site) {
		self.sites.push(site);
	};

	/**
	 * Add category to selected
	 * @param {!number} cat Category id
	 */	
	self.addCat = function(cat) {
		self.categories.push(cat);
	};

	/**
	 * Add keyword to selected
	 * @param {!string} keyword Keyword
	 */
	self.addKeyword = function(keyword) {
		if ($.inArray(keyword, self.keywords) < 0) {
			self.keywords.push(keyword);
		}
	};
	
	/**
	 * Toggle filter mode
	 */
	self.toggleFilterMode = function() {
		self.filterMode = !self.filterMode;
	}

	self.load();
};

/**
 * @type {workbreeze.settings}
 */
var settings = new workbreeze.settings();

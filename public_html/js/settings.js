var workbreeze = workbreeze || [];

/**
 * Settings
 * @constructor
 */
workbreeze.settings = function() {
	/**
	 * Settings storage name
	 * @type {string}
	 * @private
	 * @const
	 */
	this.lsname = 'settings';

	/**
	 * Sites element name
	 * @type {string}
	 * @private
	 * @const
	 */
	this.psites = 'sites';

	/**
	 * Categories element name
	 * @type {string}
	 * @private
	 * @const
	 */
	this.pcats  = 'cats';

	/**
	 * Keywords element name
	 * @type {string}
	 * @private
	 * @const
	 */
	this.pkeys  = 'keys';
	
	/**
	 * Filter mode element name
	 * @type {Boolean}
	 * @private
	 * @const
	 */
	this.pfiltermode = 'fmode';

	/** @type {Array} **/   this.keywords = [];
	/** @type {Array} **/   this.selsites = [];
	/** @type {Array} **/   this.selcats  = [];
	/** @type {Boolean} **/ this.filterMode = false;

	this.init = function() {
		this.load();
	};

	this.load = function() {
		var obj = storage.get(this.lsname);

		if (!obj) {
			return;
		}

		if (this.psites in obj) {
			this.selsites = obj[this.psites];
		}

		if (this.pcats in obj) {
			this.selcats = obj[this.pcats];
		}

		if (this.pkeys in obj) {
			this.keywords = obj[this.pkeys];
		}
		
		if (this.pfiltermode in obj) {
			this.filterMode = obj[this.pfiltermode];
		}
	};

	this.save = function() {
		var obj = {};
		obj[this.psites]      = this.selsites;
		obj[this.pcats]       = this.selcats;
		obj[this.pkeys]       = this.keywords;
		obj[this.pfiltermode] = this.filterMode;

		storage.set(this.lsname, obj);
	};

	/**
	 * Add site to selected
	 * @param {!number} site Site id
	 */
	this.addSite = function(site) {
		this.selsites.push(site);
	};

	/**
	 * Add category to selected
	 * @param {!number} cat Category id
	 */	
	this.addCat = function(cat) {
		this.selcats.push(cat);
	};

	/**
	 * Add keyword to selected
	 * @param {!string} keyword Keyword
	 */
	this.addKeyword = function(keyword) {
		this.keywords.push(keyword);
	};
	
	/**
	 * Toggle filter mode
	 */
	this.toggleFilterMode = function() {
		this.filterMode = !this.filterMode;
	}
};

/**
 * @type {workbreeze.settings}
 */
var settings = new workbreeze.settings();
settings.init();

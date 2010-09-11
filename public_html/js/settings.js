/**
 * Settings
 * @constructor
 */
function Settings() {
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

	/** @type {Array} **/ this.keywords = [];
	/** @type {Array} **/ this.selsites = [];
	/** @type {Array} **/ this.selcats  = [];

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
	};

	this.save = function() {
		var obj = {};
		obj[this.psites] = this.selsites;
		obj[this.pcats]  = this.selcats;
		obj[this.pkeys]  = this.keywords;

		storage.set(this.lsname, obj);
	};

	this.addSite = function(site) {
		this.selsites.push(site);
	};

	this.addCat = function(cat) {
		this.selcats.push(cat);
	};

	this.addKeyword = function(keyword) {
		this.keywords.push(keyword);
	};
};

var settings = new Settings();
settings.init();

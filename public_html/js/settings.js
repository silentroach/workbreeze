function settings() {
	this.keywords = [];
	this.selsites = [];
	this.selcats  = [];

	this.init = function() {
		this.load();
	}

	this.load = function() {
		if (!is_ls) {
			return;
		}

		var tmp = localStorage.getItem('settings');
		if (
			null === tmp
			|| '' == tmp
		) {
			return;
		}

		try {
			var obj = JSON.parse(tmp);
		} catch (err) {
			return;
		}

		if ('sites' in obj) {
			this.selsites = obj['sites'];
		}

		if ('cats' in obj) {
			this.selcats = obj['cats'];
		}

		if ('keys' in obj) {
			this.keywords = obj['keys'];
		}
	}

	this.save = function() {
		if (!is_ls) {
			return;
		}

		var obj = {};
		obj['sites'] = this.selsites;
		obj['cats']  = this.selcats;
		obj['keys']  = this.keywords;

		localStorage.setItem('settings', JSON.stringify(obj));
	}

	this.addSite = function(site) {
		this.selsites.push(site);
	}

	this.addCat = function(cat) {
		this.selcats.push(cat);
	}

	this.addKeyword = function(keyword) {
		this.keywords.push(keyword);
	}
}

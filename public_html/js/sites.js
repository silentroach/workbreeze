/** @type {Array} **/ var sites = [];

/**
 * Get local storage sites version
 * @return {number} Site object version
 */
function getSitesVersion() {
	if (!is_ls)
		return 0;
		
	try {
		var tmp = JSON.parse(localStorage.getItem('sites'));
	} catch (err) {
		return 0;
	}
	
	if (!tmp)
		return 0;

	if (
		'undefined' == typeof(tmp)
		|| 'undefined' == typeof(tmp['v'])
	)
		return 0;
		
	sites = tmp['vl'];

	return Math.floor(tmp['v']);
}

/**
 * Load sites
 * @param {!Object} val Load site objects from ajax request
 */
function loadSites(val) {
	var tmp = val['vl'];
	
	for (var i = 0; i < tmp.length; i++) {
		var site = tmp[i];
		
		var item = {
			folder: site['f'],
			name:  site['n'],
			url:    site['u']
		}
		
		sites[site['i']] = item;
	}
	
	if (is_ls) {
		localStorage.setItem('sites', JSON.stringify({'v': val['v'], 'vl': sites}));
	}
}

/**
 * Parse sites info
 */
function parseSites() {
	var splace = $('#sites');

	for (var i = 0; i < sites.length; i++) {				
		var site = sites[i];
		
		selsites.push(i);
		
		var c = $('<input />')
			.attr( {
				'type'   : 'checkbox',
				'id'     : 'c' + i,
				'site'   : i,
				'checked': 'checked'
			} )
			.click(handleFilter);
			
		var l = $('<label></label>')
			.attr( {
				'for' : 'c' + i
			} )
			.addClass('sico')
			.addClass('sico_' + site.folder)
			.html(site.name);
			
		var li = $('<li></li>');
		
		c.appendTo(li);
		l.appendTo(li);		
		li.appendTo(splace);			
	}
}

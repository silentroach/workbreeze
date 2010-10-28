// scripts for IE

/* <debug> */
if (!('console' in window)) {
	console = {
		log: function(e) { },
		info: function(e) { },
		warn: function(e) { },
		group: function(e) { },
		groupEnd: function(e) { }
	};
}
/* </debug> */

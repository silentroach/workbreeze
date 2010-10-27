/** @type {Boolean} **/ var updating = false;

/**
 * Ajax /up caller
 * @param {Object} s Settings
 */
$.up = function(s) {
	if (updating) {
		// see ya next time
		setTimeout(function() {
			$.up(s);
		}, 30000)
		
		return;
	}

	updating = true;

	$.ajax({
		url: '/up',
		type: 'POST',
		data: s.data,
		dataType: 'json',
		cache: false,
		success: function(data) {
			updating = false;
		
			if (s.success) {
				s.success(data);
			}
			
			if (s.ping) {
				s.ping();
			}
		},
		error: function(request, status, error) {
			updating = false;
			
/* <debug> */
			console.error(request.statusText, error);
/* </debug> */
			
			if (s.error) {
				s.error();
			}
			
			if (s.ping) {
				s.ping();
			}
		}
	});
};

/** @type {Boolean} **/ var updating = false;

$.up = function(settings) {
	if (updating) {
		// see ya next time
		setTimeout(function() {
			$.up(settings);
		}, 30000)
		
		return;
	}

	updating = true;

	$.ajax({
		url: '/up',
		type: 'POST',
		data: settings.data,
		dataType: 'json',
		cache: false,
		success: function(data) {
			updating = false;
		
			if (undefined !== settings.success) {
				settings.success(data);
			}
			
			if (undefined !== settings.ping) {
				settings.ping();
			}
		},
		error: function(request, status, error) {
			updating = false;
			
/* <debug> */
			console.error(request.statusText, error);
/* </debug> */
			
			if (undefined !== settings.error) {
				settings.error();
			}
			
			if (undefined !== settings.ping) {
				settings.ping();
			}
		}
	});
}

/**
 * Object to update get something with Ajax
 */
Workbreeze.Ajax = function(s) {
	var self = this;
	
	var options = $.extend( {
		data    : { },
		success : function(data) { },
		error   : function(request, status, error) { },
		ping    : function() { }
	}, s);

	$.ajax({
		'url': '/up',
		'type': 'POST',
		'data': options.data,
		'dataType': 'json',
		'cache': false,
		'success': function(data) {
			options.success(data);
			
			options.ping();
		},
		'error': function(request, status, error) {
			options.error(request, status, error);
			
			options.ping();
		}
	});
}

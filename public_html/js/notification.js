/* <debug> */
if ('webkitNotifications' in window) {
        console.info('html5 notifications enabled');
} else {
        console.warn('html5 notifications are not available');
}
/* </debug> */

/**
 * Notifications in HTML5
 * @constructor
 */
workbreeze.notifications = function() {

	var self = this;

	var enabled = 'webkitNotifications' in window;

	self.init = function() {
		if (!enabled)
			return;

		if (window.webkitNotifications.checkPermission() === 1) {
			/* <debug> */
			console.info('permissions are needed');
			/* </debug> */

			$(window).one('click', function() {
				window.webkitNotifications.requestPermission();
			});
		}
	}

	self.notify = function(title, body) {
		if (
			enabled
			&& window.webkitNotifications.checkPermission() === 0
		) {
			var popup = window.webkitNotifications.createNotification('/img/notification.png', title, body);
			popup.show();

//			setTimeout(function() {
//				popup.cancel();
//			}, 5000);
		}
	}

}

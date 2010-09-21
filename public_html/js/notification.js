/* <debug> */
if ('webkitNotifications' in window) {
        console.info('html5 notifications enabled');
} else {
        console.warn('html5 notifications are not available');
}
/* </debug> */

var workbreeze = workbreeze || [];

/**
 * Notifications in HTML5
 * @constructor
 */
workbreeze.notifications = function() {

	this.enabled = 'webkitNotifications' in window;

	this.init = function() {
		if (!this.enabled)
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

	this.notify = function(title, body) {
		if (
			this.enabled
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

/**
 * @type {workbreeze.notifications}
 */
var notifications = new workbreeze.notifications();

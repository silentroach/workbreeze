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

	this.enabled = false;

	this.checkEnabled = function() {
		this.enabled = (
			'webkitNotifications' in window
			|| window.webkitNotifications.checkPermission() != 2
		);
	}

	this.init = function() {
		this.checkEnabled();

		if (!this.enabled)
			return;

		if (window.webkitNotifications.checkPermission() === 1) {
			/* <debug> */
			console.info('requesting permissions for html5 notifications');
			/* </debug> */

			window.webkitNotifications.requestPermission(function() {
				this.checkEnabled();
			});
		}
	}

	this.notify = function(title, body) {
		if (
			this.enabled
			&& window.webkitNotifications.checkPermission() === 0
		) {
			var popup = window.webkitNotifications.createNotification(0, title, body);
			popup.show();

			setTimeout(function() {
				popup.cancel();
			}, 5000);
		}
	}

}

/**
 * @type {workbreeze.notifications}
 */
var notifications = new workbreeze.notifications();
notifications.init();

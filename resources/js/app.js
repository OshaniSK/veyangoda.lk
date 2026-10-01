import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('notificationDropdown', () => ({
	open: false,
	count: 0,
	notifications: [],
	pollInterval: null,
	seenNotificationIds: [],
	hasLoadedNotifications: false,

	init() {
		this.fetchNotifications();
		this.pollInterval = window.setInterval(() => this.fetchNotifications(), 10000);
	},

	destroy() {
		window.clearInterval(this.pollInterval);
	},

	toggle() {
		this.open = !this.open;
	},

	async fetchNotifications() {
		try {
			const response = await fetch('/api/notifications', {
				headers: { Accept: 'application/json' },
			});

			if (!response.ok) {
				throw new Error(`Notifications request failed: ${response.status}`);
			}

			const data = await response.json();
			const notifications = data.notifications ?? [];
			const count = data.count ?? 0;
			const hasNewNotification = this.hasLoadedNotifications
				? notifications.some(({ id }) => !this.seenNotificationIds.includes(id))
				: count > 0;

			this.count = count;
			this.notifications = notifications;
			this.seenNotificationIds = notifications.map(({ id }) => id);
			this.hasLoadedNotifications = true;

			if (hasNewNotification) {
				this.open = true;
			}
		} catch (error) {
			console.error('Notification polling error', error);
		}
	},

	async markAsRead(notification) {
		try {
			const response = await fetch(`/api/notifications/${notification.id}/read`, {
				method: 'POST',
				headers: this.requestHeaders(),
			});

			if (!response.ok) {
				throw new Error(`Mark notification read failed: ${response.status}`);
			}

			this.notifications = this.notifications.filter((item) => item.id !== notification.id);
			this.count = Math.max(0, this.count - 1);

			if (notification.data?.url) {
				window.location.assign(notification.data.url);
			}
		} catch (error) {
			console.error('Mark notification read error', error);
		}
	},

	async markAllAsRead() {
		try {
			const response = await fetch('/api/notifications/read-all', {
				method: 'POST',
				headers: this.requestHeaders(),
			});

			if (!response.ok) {
				throw new Error(`Mark all notifications read failed: ${response.status}`);
			}

			this.count = 0;
			this.notifications = [];
		} catch (error) {
			console.error('Mark all notifications read error', error);
		}
	},

	requestHeaders() {
		return {
			'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
			'Content-Type': 'application/json',
			Accept: 'application/json',
		};
	},

	formatDate(dateString) {
		const date = new Date(dateString);
		return `${date.toLocaleDateString()} ${date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
	},

	getIconClass(type) {
		switch (type) {
			case 'message': return 'bg-blue-100 text-[#2563EB]';
			case 'listing_view': return 'bg-teal-100 text-[#06B6D4]';
			case 'price_drop': return 'bg-rose-100 text-rose-600';
			default: return 'bg-violet-100 text-[#6C2BD9]';
		}
	},

	getIconSvg(iconName) {
		if (iconName === 'message') {
			return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />';
		}

		if (iconName === 'eye') {
			return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
		}

		return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />';
	},
}));

Alpine.start();

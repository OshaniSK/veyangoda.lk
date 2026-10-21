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
			case 'ad_approved': return 'bg-emerald-100 text-emerald-600';
			case 'ad_rejected': return 'bg-rose-100 text-rose-600';
			case 'message': return 'bg-blue-100 text-[#2563EB]';
			case 'listing_view': return 'bg-teal-100 text-[#06B6D4]';
			case 'price_drop': return 'bg-rose-100 text-rose-600';
			default: return 'bg-violet-100 text-[#6C2BD9]';
		}
	},

	getIconSvg(iconName) {
		if (iconName === 'check-circle' || iconName === 'approved') {
			return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />';
		}

		if (iconName === 'x-circle' || iconName === 'rejected') {
			return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />';
		}

		if (iconName === 'message') {
			return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />';
		}

		if (iconName === 'eye') {
			return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
		}

	},
}));

Alpine.data('homeFeedFilters', (config = {}) => ({
	posterType: config.initialPosterType || 'all',
	sort: config.initialSort || 'latest',
	category: config.category || '',
	subCategory: config.subCategory || '',
	search: config.search || '',
	location: config.location || '',
	loading: false,

	init() {
		window.addEventListener('popstate', (e) => {
			const params = new URLSearchParams(window.location.search);
			this.posterType = params.get('poster_type') || 'all';
			this.sort = params.get('sort') || 'latest';
			this.location = params.get('location') || '';
			this.search = params.get('search') || '';
			this.category = params.get('category') || '';
			this.subCategory = params.get('sub_category') || '';
			this.fetchListings(window.location.href, false);
		});

		window.addEventListener('location-selected', (e) => {
			const loc = (e.detail && typeof e.detail === 'object' && 'location' in e.detail) 
				? e.detail.location 
				: (e.detail || '');
			this.location = loc;
			this.applyFilters();
		});

		window.addEventListener('category-selected', (e) => {
			const detail = e.detail || {};
			this.category = detail.category || '';
			this.subCategory = detail.subCategory || '';
			this.applyFilters();
		});

		window.addEventListener('keyword-search', (e) => {
			const detail = e.detail || {};
			this.search = (typeof detail.search !== 'undefined') ? detail.search : (detail || '');
			this.applyFilters();
		});

		this.$root.addEventListener('click', (e) => {
			const paginationLink = e.target.closest('.ajax-pagination a, nav[aria-label="Pagination Navigation"] a');
			if (paginationLink && paginationLink.href) {
				e.preventDefault();
				this.fetchListings(paginationLink.href, true);
			}
		});
	},

	onPosterTypeChange(type) {
		this.posterType = type;
		this.applyFilters();
	},

	onSortChange(event) {
		this.sort = event.target.value;
		this.applyFilters();
	},

	resetToAllAds() {
		this.posterType = 'all';
		this.applyFilters();
	},

	resetFilters() {
		this.posterType = 'all';
		this.sort = 'latest';
		this.category = '';
		this.subCategory = '';
		this.search = '';
		this.location = '';
		this.applyFilters();
		window.dispatchEvent(new CustomEvent('location-selected', { detail: { location: '' } }));
		window.dispatchEvent(new CustomEvent('category-selected', { detail: { category: '', subCategory: '' } }));
		window.dispatchEvent(new CustomEvent('keyword-search', { detail: { search: '' } }));
	},

	applyFilters() {
		const url = new URL(window.location.origin + window.location.pathname);
		const currentParams = new URLSearchParams(window.location.search);

		for (const [key, value] of currentParams.entries()) {
			if (!['poster_type', 'sort', 'page', 'category', 'sub_category', 'search', 'location'].includes(key)) {
				url.searchParams.set(key, value);
			}
		}

		if (this.category) url.searchParams.set('category', this.category);
		if (this.subCategory) url.searchParams.set('sub_category', this.subCategory);
		if (this.search) url.searchParams.set('search', this.search);
		if (this.location) url.searchParams.set('location', this.location);

		if (this.posterType && this.posterType !== 'all') {
			url.searchParams.set('poster_type', this.posterType);
		} else {
			url.searchParams.delete('poster_type');
		}

		if (this.sort && this.sort !== 'latest') {
			url.searchParams.set('sort', this.sort);
		} else {
			url.searchParams.delete('sort');
		}

		this.fetchListings(url.toString(), true);
	},

	async fetchListings(url, updateHistory = true) {
		if (this.loading) return;
		this.loading = true;

		try {
			const response = await fetch(url, {
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
					'Accept': 'application/json',
				},
			});

			if (!response.ok) {
				throw new Error(`Request failed: ${response.status}`);
			}

			const data = await response.json();
			const container = document.getElementById('home-listings-container');
			if (container && data.html) {
				container.innerHTML = data.html;
			}

			if (updateHistory) {
				window.history.pushState(
					{ posterType: this.posterType, sort: this.sort },
					'',
					url
				);
			}
		} catch (err) {
			console.error('AJAX feed filtering error:', err);
			window.location.href = url;
		} finally {
			this.loading = false;
		}
	},
}));

Alpine.start();


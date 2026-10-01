<div x-data="notificationDropdown" class="relative">
    <button type="button"
            @click="toggle()"
            :aria-expanded="open.toString()"
            aria-label="Notifications"
            title="Notifications"
            class="relative p-2 rounded-full text-white/80 hover:text-white hover:bg-white/10 transition-colors focus:outline-none focus:ring-2 focus:ring-white/60">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span x-show="count > 0" x-text="count" x-cloak class="absolute top-1 right-1 flex items-center justify-center min-w-[1.25rem] h-5 px-1 text-[10px] font-bold text-white bg-rose-500 rounded-full border border-rose-600 shadow-sm"></span>
    </button>

    <div x-show="open"
         @click.outside="open = false"
         x-transition.opacity.duration.200ms
         x-cloak
         class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden z-50 origin-top-right max-h-[400px] flex flex-col"
         style="max-width: calc(100vw - 32px);">
        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex justify-between items-center shrink-0">
            <h3 class="text-sm font-bold text-slate-800">Notifications</h3>
            <span x-show="count > 0" class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-md" x-text="count + ' New'"></span>
        </div>

        <div class="overflow-y-auto flex-1 overscroll-contain">
            <div x-show="notifications.length === 0" class="p-6 text-center text-gray-500">
                <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-sm font-medium">No new notifications</p>
            </div>

            <template x-for="notification in notifications" :key="notification.id">
                <button type="button"
                        @click="markAsRead(notification)"
                        class="w-full text-left px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors flex items-start gap-3 relative"
                        :class="{'bg-blue-50/40': notification.read_at === null, 'bg-white': notification.read_at !== null}">
                    <span class="shrink-0 mt-0.5 w-8 h-8 rounded-full flex items-center justify-center shadow-sm"
                          :class="getIconClass(notification.data.type)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" x-html="getIconSvg(notification.data.icon)"></svg>
                    </span>
                    <span class="flex-1 min-w-0">
                        <span class="block text-sm text-slate-800 truncate" :class="{'font-bold': notification.read_at === null, 'font-medium': notification.read_at !== null}" x-text="notification.data.title"></span>
                        <span class="block text-xs text-slate-500 mt-0.5 line-clamp-2" x-text="notification.data.body"></span>
                        <span class="block text-[10px] text-slate-400 mt-1 font-medium uppercase" x-text="formatDate(notification.created_at)"></span>
                    </span>
                    <span x-show="notification.read_at === null" class="w-2 h-2 rounded-full bg-blue-500 shrink-0 mt-2" aria-label="Unread"></span>
                </button>
            </template>
        </div>

        <div x-show="notifications.length > 0" class="p-2 border-t border-gray-100 bg-white shrink-0 text-center">
            <button type="button" @click="markAllAsRead()" class="text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors w-full py-1.5">
                Mark all as read
            </button>
        </div>
    </div>
</div>
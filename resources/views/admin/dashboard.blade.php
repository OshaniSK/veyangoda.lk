<x-admin-layout title="Dashboard Overview">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Users</h3>
                <div class="w-10 h-10 rounded-full bg-blue-50 text-brand-blue flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-ink-primary">{{ number_format($stats['total_users']) }}</p>
            <p class="text-xs text-slate-400 mt-2"><span class="text-emerald-500 font-bold">+{{ $stats['new_users_today'] }}</span> today</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Active Listings</h3>
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-ink-primary">{{ number_format($stats['active_listings']) }}</p>
            <p class="text-xs text-slate-400 mt-2">out of {{ $stats['total_listings'] }} total ads</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Sold Items</h3>
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-ink-primary">{{ number_format($stats['sold_listings']) }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Categories</h3>
                <div class="w-10 h-10 rounded-full bg-violet-50 text-brand-violet flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-ink-primary">{{ $stats['total_categories'] }}</p>
        </div>

    </div>

    {{-- Activity Split --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Recent Listings --}}
        <div class="card">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-ink-primary">Recent Listings</h2>
                <a href="{{ route('admin.listings.index') }}" class="text-xs font-semibold text-brand-blue hover:underline">View All</a>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($recentListings as $listing)
                    <div class="p-4 flex items-center gap-4 hover:bg-slate-50">
                        <img src="{{ $listing->image_url }}" alt="" class="w-10 h-10 rounded-lg object-cover bg-slate-100 shrink-0">
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('listings.show', $listing->slug) }}" target="_blank" class="text-sm font-bold text-ink-primary hover:text-brand-blue truncate block">
                                {{ $listing->title }}
                            </a>
                            <p class="text-xs text-slate-500 mt-0.5">by {{ $listing->user->name }} &bull; {{ $listing->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="badge-{{ $listing->status === 'active' ? 'active' : ($listing->status === 'sold' ? 'closed' : 'pending') }} shrink-0">
                            {{ ucfirst($listing->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="card">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-ink-primary">New Users</h2>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-brand-blue hover:underline">View All</a>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($recentUsers as $user)
                    <div class="p-4 flex items-center gap-4 hover:bg-slate-50">
                        <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ $user->initial }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-ink-primary truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $user->email }}</p>
                        </div>
                        <span class="text-xs text-slate-400 shrink-0">{{ $user->created_at->format('M d') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</x-admin-layout>

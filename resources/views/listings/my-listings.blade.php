<x-layouts.app :title="'My Listings - ' . config('app.name')">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-ink-primary font-serif">My Listings</h1>
            <a href="{{ route('listings.create') }}" class="btn-primary">Post New Ad</a>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-3 gap-4 sm:gap-6 mb-8">
            <div class="card p-5">
                <p class="text-xs font-semibold text-ink-secondary uppercase tracking-wider">Total Ads</p>
                <p class="text-2xl font-bold text-brand-blue mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="card p-5">
                <p class="text-xs font-semibold text-ink-secondary uppercase tracking-wider">Active</p>
                <p class="text-2xl font-bold text-status-success mt-1">{{ $stats['active'] }}</p>
            </div>
            <div class="card p-5">
                <p class="text-xs font-semibold text-ink-secondary uppercase tracking-wider">Sold</p>
                <p class="text-2xl font-bold text-ink-primary mt-1">{{ $stats['sold'] }}</p>
            </div>
        </div>

        {{-- Listings Table / List --}}
        <div class="card overflow-hidden">
            @if($listings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Product</th>
                                <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider text-center">Views</th>
                                <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($listings as $listing)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" class="w-12 h-12 rounded-lg object-cover bg-slate-100">
                                            <div>
                                                <a href="{{ route('listings.show', $listing->slug) }}" class="font-bold text-ink-primary hover:text-brand-blue text-sm line-clamp-1 transition-colors">
                                                    {{ $listing->title }}
                                                </a>
                                                <p class="text-xs text-ink-secondary mt-0.5">{{ $listing->category->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-sm">{{ $listing->formatted_price }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="badge-{{ $listing->status === 'active' ? 'active' : ($listing->status === 'sold' ? 'closed' : 'pending') }}">
                                            {{ ucfirst($listing->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-ink-secondary">{{ $listing->views_count }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        @if($listing->status === 'active')
                                            <form action="{{ route('my-listings.sold', $listing) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2 py-1 rounded transition-colors" title="Mark as Sold">
                                                    Mark Sold
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('my-listings.edit', $listing) }}" class="text-xs font-bold text-brand-blue hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded transition-colors">
                                            Edit
                                        </a>

                                        <form action="{{ route('my-listings.destroy', $listing) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-2 py-1 rounded transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                <div class="p-4 border-t border-slate-100">
                    {{ $listings->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-blue-50 text-brand-blue flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-ink-primary">You haven't posted any ads yet</h3>
                    <p class="text-sm text-ink-secondary mt-1 mb-6">Start selling your homemade creations today.</p>
                    <a href="{{ route('listings.create') }}" class="btn-primary">Post Your First Ad</a>
                </div>
            @endif
        </div>

    </div>

</x-layouts.app>

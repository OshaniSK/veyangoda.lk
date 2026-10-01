<x-admin-layout title="Listing Management">

    {{-- Filters --}}
    <div class="card p-4 mb-6 flex flex-col sm:flex-row gap-4 justify-between items-center bg-white">
        <form action="{{ route('admin.listings.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <select name="status" class="input-brand !py-2 !text-sm" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
            
            <div class="flex gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search titles..." class="input-brand !py-2 !text-sm w-full sm:w-64">
                <button type="submit" class="btn-primary !px-4 !py-2 !text-sm">Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Listing</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Seller</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Price / Views</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($listings as $listing)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $listing->image_url }}" class="w-12 h-12 rounded-lg object-cover bg-slate-100 shrink-0">
                                    <div>
                                        <a href="{{ route('listings.show', $listing->slug) }}" target="_blank" class="font-bold text-ink-primary hover:text-brand-blue text-sm line-clamp-1 block">
                                            {{ $listing->title }}
                                        </a>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $listing->category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-ink-primary font-medium block">{{ $listing->user->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge-{{ $listing->status === 'active' ? 'active' : ($listing->status === 'sold' ? 'closed' : 'pending') }}">
                                    {{ ucfirst($listing->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-ink-primary">{{ $listing->formatted_price }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $listing->views_count }} views</div>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1">
                                @if($listing->status !== 'active')
                                    <form action="{{ route('admin.listings.approve', $listing) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-2 py-1 rounded transition-colors">Approve</button>
                                    </form>
                                @endif
                                
                                @if($listing->status !== 'pending')
                                    <form action="{{ route('admin.listings.reject', $listing) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs font-bold text-amber-600 bg-amber-50 hover:bg-amber-100 px-2 py-1 rounded transition-colors">Reject</button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.listings.destroy', $listing) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this listing permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 px-2 py-1 rounded transition-colors">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500 text-sm">No listings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $listings->links() }}
        </div>
    </div>

</x-admin-layout>

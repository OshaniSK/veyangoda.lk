<x-admin-layout title="Listing Management">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800" role="alert">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Pending badge alert --}}
    @if($pendingCount > 0)
        <div class="mb-5 flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm font-semibold text-amber-800">
            <svg class="h-5 w-5 shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $pendingCount }} ad{{ $pendingCount !== 1 ? 's' : '' }} awaiting your review.</span>
            <a href="{{ route('admin.listings.index', ['status' => 'pending']) }}" class="ml-auto shrink-0 rounded-lg bg-amber-500 px-3 py-1 text-xs font-bold text-white hover:bg-amber-600 transition-colors">
                Review Now →
            </a>
        </div>
    @endif

    {{-- Filters --}}
    <div class="card p-4 mb-6 flex flex-col sm:flex-row gap-4 justify-between items-center bg-white">
        <form action="{{ route('admin.listings.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <select name="status" class="input-brand !py-2 !text-sm" onchange="this.form.submit()">
                <option value="" {{ $status === '' ? 'selected' : '' }}>All Statuses</option>
                <option value="pending"  {{ $status === 'pending'  ? 'selected' : '' }}>⏳ Pending ({{ $pendingCount }})</option>
                <option value="active"   {{ $status === 'active'   ? 'selected' : '' }}>✅ Active</option>
                <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                <option value="sold"     {{ $status === 'sold'     ? 'selected' : '' }}>Sold</option>
            </select>

            <div class="flex gap-2 w-full sm:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search titles..." class="input-brand !py-2 !text-sm w-full sm:w-64">
                <button type="submit" class="btn-primary !px-4 !py-2 !text-sm">Filter</button>
            </div>
        </form>
    </div>

    {{-- Rejection reason modal (Alpine.js) --}}
    <div
        x-data="{ open: false, listingId: null, listingTitle: '' }"
        x-on:open-reject-modal.window="open = true; listingId = $event.detail.id; listingTitle = $event.detail.title"
        x-on:keydown.escape.window="open = false"
    >
        {{-- Modal backdrop --}}
        <div x-show="open" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm" @click="open = false" x-cloak></div>

        {{-- Modal panel --}}
        <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
            <div class="w-full max-w-md rounded-2xl bg-white p-7 shadow-2xl" @click.stop>
                <div class="mb-5 flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </span>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Reject Listing</h2>
                        <p class="mt-0.5 text-sm text-slate-500">Provide a reason so the seller knows what to fix.</p>
                    </div>
                    <button type="button" @click="open = false" class="ml-auto text-slate-400 hover:text-slate-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <p class="mb-4 text-sm text-slate-600">
                    Rejecting: <span class="font-bold text-slate-800" x-text="listingTitle"></span>
                </p>

                <form method="POST" :action="`/admin/listings/${listingId}/reject`">
                    @csrf
                    @method('PATCH')

                    <label for="rejection_reason" class="mb-1.5 block text-sm font-bold text-slate-700">
                        Rejection Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="rejection_reason"
                        name="rejection_reason"
                        rows="4"
                        required
                        minlength="10"
                        placeholder="e.g., Image quality too low, description is too short, prohibited item..."
                        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-red-400 focus:outline-none focus:ring-2 focus:ring-red-400/25"
                    ></textarea>
                    @error('rejection_reason')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-5 flex gap-3">
                        <button type="button" @click="open = false" class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700 transition-colors">
                            Reject & Notify Seller
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Price / Submitted</th>
                        <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($listings as $listing)
                        <tr class="hover:bg-slate-50/50 @if($listing->status === 'pending') bg-amber-50/30 @endif">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $listing->image_url }}" class="w-12 h-12 rounded-lg object-cover bg-slate-100 shrink-0" alt="">
                                    <div>
                                        @if($listing->isActive())
                                            <a href="{{ route('listings.show', $listing->slug) }}" target="_blank" class="font-bold text-ink-primary hover:text-brand-blue text-sm line-clamp-1 block">
                                                {{ $listing->title }}
                                            </a>
                                        @else
                                            <span class="font-bold text-ink-primary text-sm line-clamp-1 block">{{ $listing->title }}</span>
                                        @endif
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $listing->category->name }}</div>
                                        @if($listing->rejection_reason)
                                            <div class="mt-1 text-xs text-red-500 italic line-clamp-1" title="{{ $listing->rejection_reason }}">
                                                Reason: {{ $listing->rejection_reason }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-ink-primary font-medium block">{{ $listing->user?->name ?? '(deleted user)' }}</span>
                                @if($listing->phone_number)
                                    <span class="text-xs text-slate-400">{{ $listing->phone_number }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badgeClass = match($listing->status) {
                                        'active'   => 'bg-emerald-100 text-emerald-800',
                                        'pending'  => 'bg-amber-100 text-amber-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        default    => 'bg-slate-100 text-slate-700',
                                    };
                                    $badgeIcon = match($listing->status) {
                                        'active'   => '✅',
                                        'pending'  => '⏳',
                                        'rejected' => '❌',
                                        default    => '📦',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-bold {{ $badgeClass }}">
                                    {{ $badgeIcon }} {{ ucfirst($listing->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-ink-primary">{{ $listing->formatted_price }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $listing->created_at->diffForHumans() }}</div>
                                @if($listing->approved_at)
                                    <div class="text-xs text-emerald-600 mt-0.5">Approved {{ $listing->approved_at->diffForHumans() }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                    {{-- Approve --}}
                                    @if(! $listing->isActive())
                                        <form action="{{ route('admin.listings.approve', $listing) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-2.5 py-1.5 rounded-lg transition-colors">
                                                ✅ Approve
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Reject (opens modal) --}}
                                    @if(! $listing->isRejected())
                                        <button
                                            type="button"
                                            x-on:click="$dispatch('open-reject-modal', { id: {{ $listing->id }}, title: @js($listing->title) })"
                                            class="inline-flex items-center gap-1 text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 px-2.5 py-1.5 rounded-lg transition-colors"
                                        >
                                            ❌ Reject
                                        </button>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.listings.destroy', $listing) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this listing permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 px-2.5 py-1.5 rounded-lg transition-colors">
                                            🗑 Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">
                                @if($status === 'pending')
                                    🎉 No pending listings — you're all caught up!
                                @else
                                    No listings found.
                                @endif
                            </td>
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

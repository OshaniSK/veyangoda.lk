<x-admin-layout title="Pending Advertisements Review">

    {{-- Breadcrumb & Header --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-700">Dashboard</a>
                <span>/</span>
                <span class="text-slate-800">Pending Ads</span>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pending Ads Review</h1>
            <p class="text-sm text-slate-500 mt-0.5">Review, approve, or reject newly submitted user advertisements.</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">
                <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                {{ $pendingCount }} {{ \Illuminate\Support\Str::plural('Ad', $pendingCount) }} Pending
            </span>
            <a href="{{ route('admin.listings.index') }}" class="btn-ghost !py-2 !px-3 text-xs">
                All Listings
            </a>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800 shadow-sm" role="status">
            <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800 shadow-sm" role="alert">
            <svg class="h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Rejection Modal Component (Alpine.js) --}}
    <div
        x-data="{
            open: false,
            adId: null,
            adTitle: '',
            sellerName: '',
            openModal(data) {
                this.adId = data.id;
                this.adTitle = data.title;
                this.sellerName = data.seller;
                this.open = true;
            },
            closeModal() {
                this.open = false;
            }
        }"
        x-on:open-reject-modal.window="openModal($event.detail)"
        x-on:keydown.escape.window="closeModal()"
    >
        {{-- Backdrop --}}
        <div
            x-show="open"
            x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm"
            @click="closeModal()"
            x-cloak
        ></div>

        {{-- Dialog --}}
        <div
            x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
            x-cloak
        >
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 sm:p-8 shadow-2xl border border-slate-100" @click.stop>
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100 text-red-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Reject Advertisement</h2>
                            <p class="text-xs text-slate-500">The seller will receive this reason via email and in-app alert.</p>
                        </div>
                    </div>
                    <button type="button" @click="closeModal()" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="rounded-xl bg-slate-50 p-3.5 mb-5 border border-slate-100 text-xs text-slate-700 space-y-1">
                    <div><span class="font-semibold text-slate-500">Ad:</span> <span class="font-bold text-slate-900" x-text="adTitle"></span></div>
                    <div><span class="font-semibold text-slate-500">Seller:</span> <span x-text="sellerName"></span></div>
                </div>

                <form method="POST" :action="`/admin/ads/${adId}/reject`" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="rejection_reason" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Rejection Reason <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="rejection_reason"
                            name="rejection_reason"
                            rows="4"
                            required
                            minlength="10"
                            maxlength="1000"
                            placeholder="Please explain clearly why this ad is being rejected (e.g. photos are blurry, prohibited homemade medicine, incorrect price, copyright violation). The seller can edit and resubmit."
                            class="w-full rounded-xl border border-gray-300 p-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20"
                        ></textarea>
                        <p class="mt-1 text-[11px] text-slate-400">Minimum 10 characters.</p>
                        @error('rejection_reason')
                            <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="closeModal()" class="btn-ghost !py-2.5 !px-4 text-xs font-semibold">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-red-700 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Confirm Rejection & Notify
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="card p-4 mb-6 bg-white flex flex-col sm:flex-row gap-3 justify-between items-center">
        <form action="{{ route('admin.ads.pending') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search title or location..."
                class="input-brand !py-2 !text-sm w-full sm:w-72"
            >
            <button type="submit" class="btn-primary !py-2 !px-4 !text-xs font-bold">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.ads.pending') }}" class="btn-ghost !py-2 !px-3 text-xs">Clear</a>
            @endif
        </form>
        <span class="text-xs font-medium text-slate-500 self-end sm:self-center">
            Showing {{ $listings->count() }} of {{ $listings->total() }} pending
        </span>
    </div>

    {{-- Pending Ads Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ad Details</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Category & Location</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Seller & Contact</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Review Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($listings as $listing)
                        <tr class="hover:bg-amber-50/20 transition-colors">
                            {{-- Thumbnail & Title & Price --}}
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3.5">
                                    <a href="{{ $listing->image_url }}" target="_blank" class="shrink-0 group relative block">
                                        <img src="{{ $listing->image_url }}" alt="" class="w-16 h-16 rounded-xl object-cover bg-slate-100 border border-slate-200 group-hover:opacity-90 transition-opacity">
                                        <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/40 rounded-xl text-white text-[10px] font-bold">Preview</span>
                                    </a>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-slate-900 text-sm line-clamp-1">
                                            {{ $listing->title }}
                                        </h3>
                                        <p class="text-sm font-extrabold text-emerald-700 mt-0.5">
                                            {{ $listing->formatted_price }}
                                        </p>
                                        <p class="text-xs text-slate-500 line-clamp-2 mt-1 leading-relaxed">
                                            {{ $listing->description }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Category & Location --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 mb-1">
                                    {{ $listing->category->name }}
                                </span>
                                <div class="flex items-center gap-1 text-xs text-slate-500">
                                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $listing->location }}</span>
                                </div>
                            </td>

                            {{-- Seller & Contact --}}
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900">
                                    {{ $listing->contact_name ?: ($listing->user?->name ?? 'User #' . $listing->user_id) }}
                                </div>
                                @if($listing->phone_number)
                                    <div class="flex items-center gap-1 text-xs text-slate-600 mt-0.5">
                                        <svg class="h-3 w-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        <a href="tel:{{ $listing->phone_number }}" class="hover:underline">{{ $listing->formatted_phone ?: $listing->phone_number }}</a>
                                    </div>
                                @endif
                                @if($listing->contact_email)
                                    <div class="text-[11px] text-slate-400 truncate max-w-[150px] mt-0.5">
                                        {{ $listing->contact_email }}
                                    </div>
                                @elseif($listing->user?->email)
                                    <div class="text-[11px] text-slate-400 truncate max-w-[150px] mt-0.5">
                                        {{ $listing->user->email }}
                                    </div>
                                @endif
                            </td>

                            {{-- Date Submitted --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-semibold text-slate-700 block">
                                    {{ $listing->created_at->format('M d, Y') }}
                                </span>
                                <span class="text-[11px] text-slate-400">
                                    {{ $listing->created_at->diffForHumans() }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    {{-- Approve Button (Green) --}}
                                    <form action="{{ route('admin.ads.approve', $listing->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3.5 py-2 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 transition-colors focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                            title="Approve this advertisement and make it live"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span>Approve</span>
                                        </button>
                                    </form>

                                    {{-- Reject Button (Red) --}}
                                    <button
                                        type="button"
                                        x-on:click="$dispatch('open-reject-modal', {
                                            id: {{ $listing->id }},
                                            title: @js($listing->title),
                                            seller: @js($listing->user?->name ?? 'User')
                                        })"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3.5 py-2 text-xs font-bold text-white shadow-sm hover:bg-red-700 transition-colors focus:ring-2 focus:ring-red-500 focus:outline-none"
                                        title="Reject this ad and send feedback to the seller"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        <span>Reject</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 mb-3">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-800">All caught up!</h3>
                                <p class="text-xs text-slate-500 mt-1">There are no advertisements currently awaiting approval.</p>
                                <a href="{{ route('admin.listings.index') }}" class="btn-ghost !py-2 !px-4 text-xs mt-4 inline-flex">
                                    View All Classifieds
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($listings->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $listings->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>

<x-app-layout>
    <main class="min-h-[70vh] bg-slate-50 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <header class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-1 text-xs font-bold uppercase tracking-[0.16em] text-emerald-800">Seller dashboard</p>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">My Advertisements</h1>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">Track your ads status, manage live listings, and review submission feedback.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('listings.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-green-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Post New Ad
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex w-fit items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:border-emerald-700 hover:bg-emerald-50">
                        Go Home
                    </a>
                </div>
            </header>

            @if(session('success'))
                <div role="status" class="mb-6 rounded-xl border-l-4 border-emerald-600 bg-emerald-50 p-4 text-sm font-semibold text-emerald-900 shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div role="alert" class="mb-6 rounded-xl border-l-4 border-red-600 bg-red-50 p-4 text-sm font-semibold text-red-800 shadow-sm">{{ session('error') }}</div>
            @endif

            {{-- Summary Stats Grid --}}
            <section class="mb-8 grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4" aria-label="Listing statistics">
                <article class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Ads</p>
                    <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $stats['total'] }}</p>
                </article>
                <article class="rounded-xl border border-emerald-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Live Ads</p>
                    <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold text-emerald-600">{{ $stats['active'] }}</p>
                </article>
                <article class="rounded-xl border border-amber-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-700">Awaiting Review</p>
                    <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold text-amber-600">{{ $stats['pending'] }}</p>
                </article>
                <article class="rounded-xl border border-red-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-red-700">Rejected</p>
                    <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold text-red-600">{{ $stats['rejected'] }}</p>
                </article>
            </section>

            @if($listings->isNotEmpty())
                <section aria-label="Your advertisements">
                    <div class="mb-5 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900 sm:text-xl">All Your Ads</h2>
                        <span class="text-sm text-slate-500">{{ $listings->count() }} total</span>
                    </div>

                    @foreach($groupedListings as $groupName => $groupListings)
                        <div class="mb-8">
                            <h3 class="text-md font-bold text-slate-700 mb-4">{{ $groupName }}</h3>
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($groupListings as $listing)
                                    <article class="group flex flex-col justify-between overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                                        <div>
                                            <div class="relative block aspect-[4/3] overflow-hidden bg-slate-100">
                                                <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]">
                                                
                                                {{-- Status Badge --}}
                                                <div class="absolute left-3 top-3">
                                                    @if($listing->status === 'active')
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 border border-emerald-300 px-3 py-1 text-xs font-bold text-emerald-800 shadow-sm">
                                                            ✅ Live
                                                        </span>
                                                    @elseif($listing->status === 'pending')
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 border border-amber-300 px-3 py-1 text-xs font-bold text-amber-900 shadow-sm">
                                                            ⏳ Awaiting Approval
                                                        </span>
                                                    @elseif($listing->status === 'rejected')
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 border border-red-300 px-3 py-1 text-xs font-bold text-red-800 shadow-sm">
                                                            ❌ Rejected
                                                        </span>
                                                    @elseif($listing->status === 'sold')
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 border border-slate-300 px-3 py-1 text-xs font-bold text-slate-700 shadow-sm">
                                                            📦 Sold
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="p-4 sm:p-5">
                                                <div class="flex items-start justify-between gap-3">
                                                    <div class="min-w-0">
                                                        @if($listing->status === 'active')
                                                            <a href="{{ route('listings.show', $listing->slug) }}" class="line-clamp-2 font-bold leading-snug text-slate-900 hover:text-emerald-800">{{ $listing->title }}</a>
                                                        @else
                                                            <span class="line-clamp-2 font-bold leading-snug text-slate-900">{{ $listing->title }}</span>
                                                        @endif
                                                        <p class="mt-1 truncate text-sm text-slate-500">{{ $listing->category->name }} <span aria-hidden="true">·</span> {{ $listing->location }}</p>
                                                    </div>
                                                    <p class="shrink-0 text-sm font-extrabold text-emerald-900">{{ $listing->formatted_price }}</p>
                                                </div>

                                                {{-- Rejection Feedback Notice --}}
                                                @if($listing->status === 'rejected' && $listing->rejection_reason)
                                                    <div class="mt-3.5 rounded-lg border border-red-200 bg-red-50 p-3 text-xs text-red-900">
                                                        <div class="flex items-center gap-1.5 font-bold text-red-950 mb-1">
                                                            <svg class="h-4 w-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                            <span>Reason for Rejection:</span>
                                                        </div>
                                                        <p class="leading-relaxed text-red-800">{{ $listing->rejection_reason }}</p>
                                                    </div>
                                                @endif

                                                @if($listing->status === 'pending')
                                                    <div class="mt-3 rounded-lg border border-amber-200 bg-amber-50/60 p-2.5 text-xs text-amber-800 flex items-center gap-2">
                                                        <svg class="h-4 w-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        <span>Our team is currently reviewing your ad. You'll be notified once approved.</span>
                                                    </div>
                                                @endif

                                                <div class="mt-4 flex items-center gap-1.5 border-t border-slate-100 pt-3 text-xs font-medium text-slate-500">
                                                    <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7Z"/><circle cx="12" cy="12" r="3" stroke-width="1.8"/></svg>
                                                    {{ $listing->views_count }} views
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Actions Footer --}}
                                        <div class="p-4 sm:px-5 sm:pb-5 pt-0">
                                            <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-slate-100">
                                                @if($listing->status === 'rejected')
                                                    {{-- Edit & Resubmit button (Requested) --}}
                                                    <a href="{{ route('my-listings.edit', $listing) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 px-3.5 py-2 text-xs font-bold text-white shadow-sm transition-colors">
                                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                        Edit & Resubmit
                                                    </a>
                                                    {{-- Instant Resubmit button --}}
                                                    <form action="{{ route('my-listings.resubmit', $listing) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="inline-flex items-center rounded-lg bg-slate-100 hover:bg-slate-200 px-3 py-2 text-xs font-bold text-slate-700 transition-colors">
                                                            Resubmit As-Is
                                                        </button>
                                                    </form>
                                                @elseif($listing->status === 'active')
                                                    <form action="{{ route('my-listings.sold', $listing) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-800 transition-colors hover:bg-emerald-100">Mark Sold</button>
                                                    </form>
                                                    <a href="{{ route('my-listings.edit', $listing) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-700 hover:bg-emerald-50 hover:text-emerald-900">Edit</a>
                                                @elseif($listing->status === 'pending')
                                                    <a href="{{ route('my-listings.edit', $listing) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-700 hover:bg-emerald-50 hover:text-emerald-900">Edit Details</a>
                                                @endif

                                                <form action="{{ route('my-listings.destroy', $listing) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');" class="ml-auto">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center rounded-lg px-2.5 py-2 text-xs font-bold text-red-600 transition-colors hover:bg-red-50">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </section>
            @else
                <section class="rounded-2xl border border-slate-100 bg-white px-6 py-14 text-center shadow-lg shadow-slate-900/5 sm:px-10 sm:py-16">
                    <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                        <svg aria-hidden="true" class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 8.5 12 4l9 4.5v10L12 23l-9-4.5v-10Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m3.5 8.8 8.5 4.3 8.5-4.3M12 13v9.5"/></svg>
                    </div>
                    <h2 class="text-xl font-extrabold text-slate-900 sm:text-2xl">You haven't posted any ads yet</h2>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-600 sm:text-base">Start selling your homemade creations today. All ads are reviewed quickly by our team.</p>
                    <a href="{{ route('listings.create') }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#F59E0B] px-6 py-3 font-bold text-green-900 shadow-sm transition hover:scale-[1.02] hover:bg-amber-500 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-600 focus-visible:ring-offset-2">Post Your First Ad</a>
                </section>
            @endif
        </div>
    </main>
</x-app-layout>
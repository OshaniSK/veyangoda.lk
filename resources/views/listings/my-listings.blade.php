<x-app-layout>
    <main class="min-h-[70vh] bg-slate-50 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <header class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-1 text-xs font-bold uppercase tracking-[0.16em] text-emerald-800">Seller dashboard</p>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">My Listings</h1>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">Manage your active ads and track sales performance.</p>
                </div>
                <a href="{{ route('home') }}" class="inline-flex w-fit items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:border-emerald-700 hover:bg-emerald-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-700 focus-visible:ring-offset-2">
                    <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19 3 12l7-7M3 12h18"/></svg>
                    Go Home
                </a>
            </header>

            @if(session('success'))
                <div role="status" class="mb-6 rounded-lg border-l-4 border-emerald-600 bg-emerald-50 p-4 text-sm font-semibold text-emerald-900">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div role="alert" class="mb-6 rounded-lg border-l-4 border-red-600 bg-red-50 p-4 text-sm font-semibold text-red-800">{{ session('error') }}</div>
            @endif

            <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3 sm:gap-5" aria-label="Listing statistics">
                <article class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Ads</p>
                            <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['total'] }}</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                            <svg aria-hidden="true" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m4.5 7.5 7.5 4.2 7.5-4.2M12 12v9m-4-15 8 4.5"/></svg>
                        </span>
                    </div>
                </article>
                <article class="rounded-xl border border-emerald-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Active</p>
                            <p class="mt-2 text-3xl font-extrabold text-emerald-600">{{ $stats['active'] }}</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg aria-hidden="true" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 12 2.5 2.5L16 9"/></svg>
                        </span>
                    </div>
                </article>
                <article class="rounded-xl border border-amber-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Sold</p>
                            <p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $stats['sold'] }}</p>
                        </div>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <svg aria-hidden="true" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m20.6 13.1-7.5 7.5a2 2 0 0 1-2.8 0l-6.9-6.9a2 2 0 0 1-.6-1.4V5a2 2 0 0 1 2-2h7.3a2 2 0 0 1 1.4.6l7.1 6.7a2 2 0 0 1 0 2.8Z"/><circle cx="8.5" cy="8.5" r="1.25" fill="currentColor" stroke="none"/></svg>
                        </span>
                    </div>
                </article>
            </section>

            @if($listings->isNotEmpty())
                <section aria-label="Your advertisements">
                    <div class="mb-5 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900 sm:text-xl">Your advertisements</h2>
                        <span class="text-sm text-slate-500">{{ $listings->count() }} total</span>
                    </div>

                    @foreach($groupedListings as $groupName => $groupListings)
                        <div class="mb-8">
                            <h3 class="text-md font-bold text-slate-700 mb-4">{{ $groupName }}</h3>
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($groupListings as $listing)
                                    <article class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                                        <a href="{{ route('listings.show', $listing->slug) }}" class="relative block aspect-[4/3] overflow-hidden bg-slate-100">
                                            <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]">
                                            <span @class([
                                                'absolute left-3 top-3 inline-flex items-center rounded-full px-3 py-1 text-xs font-bold shadow-sm',
                                                'bg-emerald-100 text-emerald-800' => $listing->status === 'active',
                                                'bg-amber-100 text-amber-900' => $listing->status === 'sold',
                                                'bg-slate-100 text-slate-700' => ! in_array($listing->status, ['active', 'sold'], true),
                                            ])>{{ ucfirst($listing->status) }}</span>
                                        </a>
                                        <div class="p-4 sm:p-5">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <a href="{{ route('listings.show', $listing->slug) }}" class="line-clamp-2 font-bold leading-snug text-slate-900 hover:text-emerald-800">{{ $listing->title }}</a>
                                            <p class="mt-1 truncate text-sm text-slate-500">{{ $listing->category->name }} <span aria-hidden="true">·</span> {{ $listing->location }}</p>
                                        </div>
                                        <p class="shrink-0 text-sm font-extrabold text-emerald-900">{{ $listing->formatted_price }}</p>
                                    </div>
                                    <div class="mt-4 flex items-center gap-1.5 border-t border-slate-100 pt-3 text-xs font-medium text-slate-500">
                                        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/><circle cx="12" cy="12" r="3" stroke-width="1.8"/></svg>
                                        {{ $listing->views_count }} views
                                    </div>
                                    <div class="mt-4 flex flex-wrap items-center gap-2">
                                        @if($listing->status === 'active')
                                            <form action="{{ route('my-listings.sold', $listing) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-800 transition-colors hover:bg-emerald-100">Mark Sold</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('my-listings.edit', $listing) }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-700 hover:bg-emerald-50 hover:text-emerald-900">Edit</a>
                                        <form action="{{ route('my-listings.destroy', $listing) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-lg px-3 py-2 text-xs font-bold text-red-700 transition-colors hover:bg-red-50">Delete</button>
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
                    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-600 sm:text-base">Start selling your homemade creations today.</p>
                    <a href="{{ route('listings.create') }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#F59E0B] px-6 py-3 font-bold text-green-900 shadow-sm transition hover:scale-[1.02] hover:bg-amber-500 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-600 focus-visible:ring-offset-2">Post Your First Ad</a>
                </section>
            @endif
        </div>
    </main>
</x-app-layout>
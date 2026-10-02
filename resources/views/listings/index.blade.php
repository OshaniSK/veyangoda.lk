<x-app-layout>
    <main class="min-h-[70vh] bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 pb-12 pt-6 sm:px-6 sm:pt-8 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-4 text-sm">
                <ol class="flex flex-wrap items-center gap-2 text-slate-500">
                    <li><a href="{{ route('home') }}" class="font-medium text-emerald-800 hover:text-emerald-950 hover:underline">Home</a></li>
                    <li aria-hidden="true" class="text-slate-400">/</li>
                    <li aria-current="page" class="font-medium text-slate-700">{{ $activeCategory?->name ?? 'Browse Ads' }}</li>
                </ol>
            </nav>

            <header class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-1 text-xs font-bold uppercase tracking-[0.16em] text-emerald-800">Veyangoda.lk marketplace</p>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">{{ $activeCategory?->name ?? ($search !== '' ? 'Search Results' : 'Browse Ads') }}</h1>
                    <p class="mt-2 text-sm text-slate-600 sm:text-base">
                        @if($activeCategory)
                            Discover {{ strtolower($activeCategory->name) }} from local sellers across Sri Lanka.
                        @elseif($search !== '')
                            Listings matching “{{ $search }}”.
                        @else
                            Find homemade goods, local services, and more from sellers across Sri Lanka.
                        @endif
                    </p>
                </div>
                <a href="{{ route('listings.create') }}" class="inline-flex w-fit items-center gap-2 rounded-lg bg-[#F59E0B] px-4 py-2.5 text-sm font-bold text-green-900 shadow-sm transition hover:bg-amber-500 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-600 focus-visible:ring-offset-2">
                    <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m7-7H5"/></svg>
                    Post an Ad
                </a>
            </header>

            <section class="sticky top-16 z-30 mb-6 rounded-xl border border-slate-200 bg-white/95 p-3 shadow-md shadow-slate-900/5 backdrop-blur sm:top-20 sm:p-4" aria-label="Browse filters">
                <form action="{{ route('listings.index') }}" method="GET" class="grid grid-cols-1 gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(180px,0.65fr)_minmax(190px,0.7fr)_auto] sm:items-end">
                    @if($activeCategory)
                        <input type="hidden" name="category" value="{{ $activeCategory->slug }}">
                    @endif
                    <div>
                        <label for="browse-search" class="mb-1.5 block text-xs font-bold text-slate-600">Keyword</label>
                        <input id="browse-search" type="search" name="search" value="{{ $search }}" placeholder="Search listings" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-500 focus:border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-700/20">
                    </div>

                    <div>
                        <label for="browse-location" class="mb-1.5 block text-xs font-bold text-slate-600">Location</label>
                        <select id="browse-location" name="location" class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-700/20">
                            <option value="">All locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" @selected(request('location') === $location)>{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="browse-sort" class="mb-1.5 block text-xs font-bold text-slate-600">Sort by</label>
                        <select id="browse-sort" name="sort" class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-slate-800 focus:border-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-700/20">
                            <option value="latest" @selected($sort === 'latest')>Newest</option>
                            <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
                        </select>
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#1E3A29] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-950 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-700 focus-visible:ring-offset-2">
                        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Apply
                    </button>
                </form>

                @if($activeCategory || $search !== '' || request()->filled('location') || ($sort !== 'latest'))
                    <div class="mt-3 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-3" aria-label="Active filters">
                        <span class="mr-1 text-xs font-semibold text-slate-500">Active filters</span>
                        @if($activeCategory)
                            <a href="{{ route('listings.index', request()->except(['category', 'category_id', 'page'])) }}" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-900 hover:bg-emerald-100">
                                {{ $activeCategory->name }} <span aria-hidden="true">×</span><span class="sr-only">Remove category filter</span>
                            </a>
                        @endif
                        @if($search !== '')
                            <a href="{{ route('listings.index', request()->except(['search', 'q', 'page'])) }}" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-900 hover:bg-emerald-100">
                                “{{ $search }}” <span aria-hidden="true">×</span><span class="sr-only">Remove keyword filter</span>
                            </a>
                        @endif
                        @if(request()->filled('location'))
                            <a href="{{ route('listings.index', request()->except(['location', 'page'])) }}" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-900 hover:bg-emerald-100">
                                {{ request('location') }} <span aria-hidden="true">×</span><span class="sr-only">Remove location filter</span>
                            </a>
                        @endif
                        @if($sort !== 'latest')
                            <a href="{{ route('listings.index', request()->except(['sort', 'page'])) }}" class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-950 hover:bg-amber-200">
                                {{ $sort === 'price_asc' ? 'Price: Low to High' : 'Price: High to Low' }} <span aria-hidden="true">×</span><span class="sr-only">Remove sort filter</span>
                            </a>
                        @endif
                        <a href="{{ route('listings.index') }}" class="ml-auto text-xs font-semibold text-slate-500 underline decoration-slate-300 underline-offset-2 hover:text-emerald-900">Clear all</a>
                    </div>
                @endif
            </section>

            <section aria-label="Listing results">
                <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
                    <p class="text-sm text-slate-600" aria-live="polite">
                        Showing <span class="font-bold text-slate-900">{{ $listings->total() }}</span>
                        {{ $listings->total() === 1 ? 'ad' : 'ads' }}
                        @if($activeCategory)
                            in <span class="font-semibold text-slate-900">{{ $activeCategory->name }}</span>
                        @elseif($search !== '')
                            matching <span class="font-semibold text-slate-900">“{{ $search }}”</span>
                        @else
                            across Veyangoda.lk
                        @endif
                        @if(request()->filled('location'))
                            in <span class="font-semibold text-slate-900">{{ request('location') }}</span>
                        @endif
                    </p>
                    <span class="text-xs text-slate-500">{{ $listings->firstItem() ?? 0 }}–{{ $listings->lastItem() ?? 0 }} of {{ $listings->total() }}</span>
                </div>

                @if($listings->isNotEmpty())
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($listings as $listing)
                            <x-listing-card :listing="$listing" />
                        @endforeach
                    </div>
                    <div class="mt-8">{{ $listings->links() }}</div>
                @else
                    <div class="rounded-2xl border border-slate-200 bg-white px-5 py-14 text-center shadow-sm sm:px-10">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-800">
                            <svg aria-hidden="true" class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 8.5 12 4l9 4.5v10L12 23l-9-4.5v-10Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m3.5 8.8 8.5 4.3 8.5-4.3M12 13v9.5"/></svg>
                        </div>
                        <h2 class="text-xl font-extrabold text-slate-900">No ads found{{ $activeCategory ? ' in ' . $activeCategory->name : '' }}.</h2>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-600">Be the first to post in this category and introduce your creation to local buyers.</p>
                        <a href="{{ route('listings.create') }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#F59E0B] px-6 py-3 font-bold text-green-900 shadow-sm transition hover:bg-amber-500 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-600 focus-visible:ring-offset-2">Be the First to Post</a>
                    </div>
                @endif
            </section>
        </div>
    </main>
</x-app-layout>
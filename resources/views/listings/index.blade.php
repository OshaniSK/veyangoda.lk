<x-layouts.app>
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-b from-amber-50/70 via-stone-50 to-stone-50 pt-10 pb-12 sm:pt-14 sm:pb-16 border-b border-stone-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-100/80 text-amber-900 text-xs font-semibold mb-4 border border-amber-200">
                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                <span>Support Sri Lankan Small Cottage Industries</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-extrabold text-stone-900 tracking-tight font-serif max-w-3xl mx-auto leading-tight">
                Authentic Homemade Goods, <br class="hidden sm:inline">
                <span class="text-amber-800 underline decoration-amber-300 decoration-wavy decoration-2">Directly from the Makers.</span>
            </h1>

            <p class="mt-4 text-sm sm:text-base text-stone-600 max-w-2xl mx-auto leading-relaxed">
                Discover small-batch homemade candles, organic pickles, handloom textiles, and domestic crafts. Zero dealer markups.
            </p>

            {{-- Clean Search & Discovery Filter Bar --}}
            <div class="mt-8 max-w-4xl mx-auto">
                <form action="{{ route('home') }}" method="GET" class="bg-white p-2.5 sm:p-3 rounded-2xl shadow-xl shadow-stone-900/5 border border-stone-200 flex flex-col sm:flex-row gap-2">
                    {{-- Keyword Input --}}
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}" 
                            placeholder="What homemade item are you looking for? (e.g. Candles, Jams, Batik)"
                            class="w-full pl-10 pr-3 py-3 text-sm bg-transparent border-0 rounded-xl focus:ring-2 focus:ring-amber-500 placeholder-stone-400 text-stone-900 font-medium"
                        >
                    </div>

                    <div class="hidden sm:block w-px bg-stone-200 my-1"></div>

                    {{-- Location Filter --}}
                    <div class="relative sm:w-56">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="location" 
                            value="{{ request('location') }}" 
                            placeholder="City or District (e.g. Kandy)"
                            class="w-full pl-10 pr-3 py-3 text-sm bg-transparent border-0 rounded-xl focus:ring-2 focus:ring-amber-500 placeholder-stone-400 text-stone-900 font-medium"
                        >
                    </div>

                    {{-- Search Action Button --}}
                    <button 
                        type="submit" 
                        class="sm:w-auto px-6 py-3 rounded-xl bg-amber-700 hover:bg-amber-800 text-white font-bold text-sm shadow-md transition-all active:scale-95 flex items-center justify-center gap-2"
                    >
                        <span>Search</span>
                    </button>
                </form>
            </div>

            {{-- Quick Category Filter Chips --}}
            <div class="mt-6 flex items-center justify-center gap-2 flex-wrap">
                <a 
                    href="{{ route('home') }}" 
                    class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all {{ !request('category') ? 'bg-amber-700 text-white shadow-sm' : 'bg-white text-stone-600 hover:bg-stone-100 border border-stone-200' }}"
                >
                    All Items
                </a>
                @foreach($categories as $cat)
                    <a 
                        href="{{ route('home', array_merge(request()->query(), ['category' => $cat->slug])) }}" 
                        class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all inline-flex items-center gap-1.5 {{ request('category') === $cat->slug ? 'bg-amber-700 text-white shadow-sm' : 'bg-white text-stone-600 hover:bg-stone-100 border border-stone-200' }}"
                    >
                        <span>{{ $cat->name }}</span>
                        <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ request('category') === $cat->slug ? 'bg-amber-800 text-amber-100' : 'bg-stone-100 text-stone-500' }}">
                            {{ $cat->listings_count }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Main Active Advertisements Feed --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Toolbar: Results count & Sort dropdown --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-stone-200 mb-8">
            <div>
                <h2 class="text-xl font-bold text-stone-900 tracking-tight">
                    @if(request('category'))
                        {{ ucwords(str_replace('-', ' ', request('category'))) }}
                    @elseif(request('q'))
                        Search results for "{{ request('q') }}"
                    @else
                        Active Domestic Advertisements
                    @endif
                </h2>
                <p class="text-xs text-stone-500 mt-0.5">
                    Showing {{ $listings->total() }} verified homemade products from local makers
                </p>
            </div>

            {{-- Sort Options Form --}}
            <form action="{{ route('home') }}" method="GET" class="flex items-center gap-2 self-end sm:self-auto">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                @if(request('location'))
                    <input type="hidden" name="location" value="{{ request('location') }}">
                @endif

                <label for="sort" class="text-xs font-semibold text-stone-500 uppercase tracking-wider shrink-0">Sort By:</label>
                <select 
                    id="sort" 
                    name="sort" 
                    onchange="this.form.submit()" 
                    class="text-xs font-medium rounded-xl border-stone-200 bg-white py-1.5 pl-3 pr-8 text-stone-700 focus:border-amber-500 focus:ring-amber-500"
                >
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Newest Listed</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Viewed</option>
                </select>
            </form>
        </div>

        {{-- Listing Cards Grid --}}
        @if($listings->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($listings as $listing)
                    <x-listing-card :listing="$listing" />
                @endforeach
            </div>

            {{-- Pagination Navigation --}}
            <div class="mt-12">
                {{ $listings->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16 bg-white rounded-3xl border border-stone-200 p-8">
                <div class="w-16 h-16 mx-auto rounded-full bg-amber-50 text-amber-700 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-stone-900">No homemade items match your filters</h3>
                <p class="text-sm text-stone-500 mt-1 max-w-sm mx-auto">
                    Try clearing your location or price criteria, or browse all categories to explore our artisan collection.
                </p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-amber-700 hover:bg-amber-800 text-white font-semibold text-xs transition-colors">
                        Reset All Filters
                    </a>
                </div>
            </div>
        @endif
    </section>
</x-layouts.app>

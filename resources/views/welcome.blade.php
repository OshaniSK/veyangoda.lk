<x-app-layout>
    <x-hero-section :locations="$locations" :categories="$categories" />

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        
        <!-- Filters Section -->
        <form method="GET" action="{{ route('home') }}" class="mb-6 flex flex-col sm:flex-row gap-4 items-start sm:items-end justify-between bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-sm" x-data="{ submit() { this.$el.submit() } }">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Type of poster:</label>
                    <div class="flex gap-5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="poster_type" value="all" @change="submit()" {{ request('poster_type', 'all') === 'all' ? 'checked' : '' }} class="text-[#008060] focus:ring-[#008060] h-4 w-4 border-slate-300">
                            <span class="text-sm font-semibold text-slate-700">All ads</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="poster_type" value="members" @change="submit()" {{ request('poster_type') === 'members' ? 'checked' : '' }} class="text-[#008060] focus:ring-[#008060] h-4 w-4 border-slate-300">
                            <span class="text-sm font-semibold text-slate-700">Only members</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="w-full sm:w-64 mt-4 sm:mt-0">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sort results by:</label>
                <select name="sort" @change="submit()" class="w-full rounded-lg border-slate-200 text-sm font-medium focus:border-[#008060] focus:ring-[#008060] shadow-sm">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8">
            
            <!-- Left Sidebar -->
            <aside class="hidden lg:block">
                <div class="sticky top-24">
                    <x-categories-sidebar :categories="$categories" />
                </div>
            </aside>
            
            <!-- Mobile Sidebar Toggle -->
            <div class="lg:hidden mb-6" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-between bg-white p-4 rounded-xl border border-slate-100 shadow-sm text-slate-700 font-bold">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        Browse Categories
                    </span>
                    <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse class="mt-4">
                    <x-categories-sidebar :categories="$categories" />
                </div>
            </div>

            <!-- Main Content -->
            <main>
                <!-- Featured Ads Section -->
                @if(!request()->has('category') && !request()->has('search'))
                    <x-featured-ads :ads="$featuredAds" />
                @endif
                
                <!-- Regular Ads Section -->

                <section>
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">
                            @if(request('category'))
                                Ads in {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Category' }}
                            @elseif(request('search'))
                                Search results for "{{ request('search') }}"
                            @else
                                Ads in Sri Lanka
                            @endif
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Showing {{ $listings->firstItem() ?? 0 }}-{{ $listings->lastItem() ?? 0 }} of {{ number_format($listings->total()) }} ads
                        </p>
                    </div>

                    @if($listings->count() > 0)
                        <div class="flex flex-col gap-4">
                            @foreach($listings as $listing)
                                <x-ad-card :listing="$listing" layout="list" />
                            @endforeach
                        </div>
                        
                        <div class="mt-8">
                            {{ $listings->links() }}
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center rounded-2xl border border-slate-100 bg-white px-4 py-16 text-center shadow-sm">
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-50">
                                <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">No ads found</h3>
                            <p class="mt-2 text-sm text-slate-500">Try adjusting your filters or search criteria.</p>
                            <a href="{{ route('home') }}" class="mt-6 font-semibold text-[#008060] hover:underline">Clear all filters</a>
                        </div>
                    @endif
                </section>
            </main>
        </div>

        {{-- Start Selling CTA Section (Moved to the bottom of the homepage, just above the footer) --}}
        @if(!request()->has('category') && !request()->has('search'))
            <x-start-selling-cta />
        @endif
    </div>
</x-app-layout>


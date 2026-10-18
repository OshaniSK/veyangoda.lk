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
                
                <!-- Turn Creativity into Income Banner (moved up slightly) -->
                @if(!request()->has('category') && !request()->has('search'))
                    <section class="mb-10 overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm">
                        <div class="grid items-center gap-6 p-6 sm:p-8 lg:grid-cols-[0.8fr_1.2fr] lg:gap-8">
                            <div class="order-2 flex min-h-40 items-center justify-center rounded-xl bg-emerald-50 sm:min-h-48 lg:order-1" aria-hidden="true">
                                <svg class="h-32 w-40 sm:h-40 sm:w-48" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M31 164h178" stroke="#A7F3D0" stroke-width="5" stroke-linecap="round"/>
                                    <rect x="42" y="111" width="156" height="51" rx="7" fill="#D1FAE5" stroke="#047857" stroke-width="3"/>
                                    <path d="M33 111h174l-12-23H45l-12 23Z" fill="#FACC15" stroke="#064E3B" stroke-width="3" stroke-linejoin="round"/>
                                    <path d="M51 89V69h138v20" stroke="#064E3B" stroke-width="3" stroke-linecap="round"/>
                                    <path d="M63 111V92h21v19m23 0V92h21v19m23 0V92h21v19" fill="#fff" stroke="#047857" stroke-width="2.5"/>
                                    <circle cx="121" cy="43" r="17" fill="#F4C7A1" stroke="#064E3B" stroke-width="3"/>
                                    <path d="M104 43c0-14 8-22 20-22 10 0 17 7 17 19-6-5-13-7-21-6-5 1-10 4-16 9Z" fill="#334155"/>
                                    <path d="M102 107V80c0-12 8-19 19-19s20 7 20 19v27" fill="#34D399" stroke="#064E3B" stroke-width="3"/>
                                    <path d="m103 77-18 19m55-19 17 19" stroke="#F4C7A1" stroke-width="8" stroke-linecap="round"/>
                                    <path d="M81 91h19v20H81z" fill="#FB923C" stroke="#9A3412" stroke-width="2.5"/>
                                    <path d="M84 91c1-8 12-8 13 0" stroke="#9A3412" stroke-width="2.5"/>
                                    <path d="M161 97h20v14h-20z" fill="#60A5FA" stroke="#1D4ED8" stroke-width="2.5"/>
                                    <path d="m166 97 5-8 5 8" stroke="#1D4ED8" stroke-width="2.5" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="order-1 text-center lg:order-2 lg:text-left">
                                <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.16em] text-emerald-700">For local makers and sellers</p>
                                <h2 class="text-xl font-extrabold leading-tight text-slate-900 sm:text-2xl">Turn Your Creativity into Income.</h2>
                                <p class="mx-auto mt-2 max-w-xl text-sm leading-relaxed text-slate-600 lg:mx-0">Join thousands of local artisans and sellers on Veyangoda.lk. It's free and takes seconds.</p>
                                <a href="{{ route('listings.create') }}" class="mt-4 inline-flex items-center justify-center gap-2 rounded-lg bg-accent-yellow px-5 py-2.5 text-sm font-bold text-dark-green shadow-sm transition hover:bg-yellow-300 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2">
                                    Start Selling Now
                                    <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </section>
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
    </div>
</x-app-layout>

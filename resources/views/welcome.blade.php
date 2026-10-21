<x-app-layout>
    <x-hero-section :locations="$locations" :categories="$categories" />

    <div
        x-data="homeFeedFilters({
            initialPosterType: @js(request('poster_type', 'all')),
            initialSort: @js(request('sort', 'latest')),
            category: @js(request('category', '')),
            search: @js(request('search', '')),
            location: @js(request('location', ''))
        })"
        class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8"
    >
        <!-- Filters Section -->
        <div class="relative mb-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-end justify-between bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Type of poster:</label>
                        <div class="flex gap-5">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input
                                    type="radio"
                                    name="poster_type"
                                    value="all"
                                    :checked="posterType === 'all'"
                                    @change="onPosterTypeChange('all')"
                                    class="text-[#008060] focus:ring-[#008060] h-4 w-4 border-slate-300 cursor-pointer"
                                >
                                <span class="text-sm font-semibold text-slate-700">All ads</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input
                                    type="radio"
                                    name="poster_type"
                                    value="members"
                                    :checked="posterType === 'members'"
                                    @change="onPosterTypeChange('members')"
                                    class="text-[#008060] focus:ring-[#008060] h-4 w-4 border-slate-300 cursor-pointer"
                                >
                                <span class="text-sm font-semibold text-slate-700 flex items-center gap-1.5">
                                    <span>Only members</span>
                                    <span class="inline-flex items-center rounded-md bg-emerald-50 px-1.5 py-0.5 text-[10px] font-bold text-emerald-800 border border-emerald-200">Followed</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="w-full sm:w-64 mt-4 sm:mt-0">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sort results by:</label>
                    <select
                        name="sort"
                        :value="sort"
                        @change="onSortChange($event)"
                        class="w-full rounded-lg border-slate-200 text-sm font-medium focus:border-[#008060] focus:ring-[#008060] shadow-sm cursor-pointer"
                    >
                        <option value="latest">Latest</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>
            </div>

            {{-- Floating loading feedback --}}
            <div
                x-show="loading"
                x-transition.opacity
                class="absolute inset-0 bg-white/70 backdrop-blur-[1px] rounded-2xl flex items-center justify-center z-10"
                style="display: none;"
            >
                <div class="inline-flex items-center gap-2 bg-slate-900/90 text-white text-xs font-bold py-2 px-4 rounded-full shadow-lg">
                    <svg class="animate-spin h-3.5 w-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Updating listings...</span>
                </div>
            </div>
        </div>

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
                    <div x-show="posterType === 'all' && !category && !search" x-transition.opacity>
                        <x-featured-ads :ads="$featuredAds" />
                    </div>
                @endif
                
                <!-- Regular Ads Section (Updated via AJAX) -->
                <section
                    id="home-listings-container"
                    class="relative transition-opacity duration-200"
                    :class="loading ? 'opacity-40 pointer-events-none' : 'opacity-100'"
                >
                    @include('partials.home-listings')
                </section>
            </main>
        </div>

        {{-- Start Selling CTA Section (Moved to the bottom of the homepage, just above the footer) --}}
        @if(!request()->has('category') && !request()->has('search'))
            <x-start-selling-cta />
        @endif
    </div>

    {{-- Inline script registration to ensure compatibility with CDN Alpine.js fallback --}}
    <script>
        (function() {
            function initHomeFeedFilters() {
                if (window.Alpine && typeof Alpine.data === 'function') {
                    if (!Alpine.data('homeFeedFilters')) {
                        Alpine.data('homeFeedFilters', (config = {}) => ({
                            posterType: config.initialPosterType || 'all',
                            sort: config.initialSort || 'latest',
                            category: config.category || '',
                            search: config.search || '',
                            location: config.location || '',
                            loading: false,

                            init() {
                                window.addEventListener('popstate', () => {
                                    const params = new URLSearchParams(window.location.search);
                                    this.posterType = params.get('poster_type') || 'all';
                                    this.sort = params.get('sort') || 'latest';
                                    this.fetchListings(window.location.href, false);
                                });

                                this.$root.addEventListener('click', (e) => {
                                    const paginationLink = e.target.closest('.ajax-pagination a, nav[aria-label="Pagination Navigation"] a');
                                    if (paginationLink && paginationLink.href) {
                                        e.preventDefault();
                                        this.fetchListings(paginationLink.href, true);
                                    }
                                });
                            },

                            onPosterTypeChange(type) {
                                this.posterType = type;
                                this.applyFilters();
                            },

                            onSortChange(event) {
                                this.sort = event.target.value;
                                this.applyFilters();
                            },

                            resetToAllAds() {
                                this.posterType = 'all';
                                this.applyFilters();
                            },

                            resetFilters() {
                                this.posterType = 'all';
                                this.sort = 'latest';
                                this.category = '';
                                this.search = '';
                                this.location = '';
                                this.applyFilters();
                            },

                            applyFilters() {
                                const url = new URL(window.location.origin + window.location.pathname);
                                const currentParams = new URLSearchParams(window.location.search);

                                for (const [key, value] of currentParams.entries()) {
                                    if (key !== 'poster_type' && key !== 'sort' && key !== 'page') {
                                        url.searchParams.set(key, value);
                                    }
                                }

                                if (this.category) url.searchParams.set('category', this.category);
                                if (this.search) url.searchParams.set('search', this.search);
                                if (this.location) url.searchParams.set('location', this.location);

                                if (this.posterType && this.posterType !== 'all') {
                                    url.searchParams.set('poster_type', this.posterType);
                                } else {
                                    url.searchParams.delete('poster_type');
                                }

                                if (this.sort && this.sort !== 'latest') {
                                    url.searchParams.set('sort', this.sort);
                                } else {
                                    url.searchParams.delete('sort');
                                }

                                this.fetchListings(url.toString(), true);
                            },

                            async fetchListings(url, updateHistory = true) {
                                if (this.loading) return;
                                this.loading = true;

                                try {
                                    const response = await fetch(url, {
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json',
                                        },
                                    });

                                    if (!response.ok) {
                                        throw new Error(`Request failed: ${response.status}`);
                                    }

                                    const data = await response.json();
                                    const container = document.getElementById('home-listings-container');
                                    if (container && data.html) {
                                        container.innerHTML = data.html;
                                    }

                                    if (updateHistory) {
                                        window.history.pushState(
                                            { posterType: this.posterType, sort: this.sort },
                                            '',
                                            url
                                        );
                                    }
                                } catch (err) {
                                    console.error('AJAX feed filtering error:', err);
                                    window.location.href = url;
                                } finally {
                                    this.loading = false;
                                }
                            },
                        }));
                    }
                }
            }

            if (window.Alpine) {
                initHomeFeedFilters();
            } else {
                document.addEventListener('alpine:init', initHomeFeedFilters);
            }
        })();
    </script>
</x-app-layout>

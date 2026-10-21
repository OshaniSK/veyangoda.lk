@props(['categories' => null])

@php
    // Category and subcategory labels with icons
    $categoryStructure = [
        'vehicles' => [
            'name' => 'Vehicles',
            'slug' => 'vehicles',
            'icon' => '🚗',
            'icon_bg' => 'bg-amber-100 text-amber-800',
            'subcategories' => [
                ['name' => 'Cars', 'slug' => 'cars', 'icon' => '🚙'],
                ['name' => 'Motorbikes & Scooters', 'slug' => 'motorbikes-scooters', 'icon' => '🏍️'],
                ['name' => 'Three Wheelers', 'slug' => 'three-wheelers', 'icon' => '🛺'],
                ['name' => 'Push Cycles', 'slug' => 'push-cycles', 'icon' => '🚲'],
                ['name' => 'Vans, Buses & Lorries', 'slug' => 'vans-buses-lorries', 'icon' => '🚐'],
                ['name' => 'Heavy Machinery & Tractors', 'slug' => 'heavy-machinery-tractors', 'icon' => '🚜'],
                ['name' => 'Auto Services', 'slug' => 'auto-services', 'icon' => '🔧'],
                ['name' => 'Auto Parts & Accessories', 'slug' => 'auto-parts-accessories', 'icon' => '⚙️'],
                ['name' => 'Boats & Water Transport', 'slug' => 'boats-water-transport', 'icon' => '🚤'],
            ],
        ],
        'electronics' => [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'icon' => '💻',
            'icon_bg' => 'bg-blue-100 text-blue-800',
            'subcategories' => [
                ['name' => 'Mobile Phones & Accessories', 'slug' => 'mobile-phones-accessories', 'icon' => '📱'],
                ['name' => 'Computers & Laptops', 'slug' => 'computers-laptops', 'icon' => '💻'],
                ['name' => 'TVs & Audio', 'slug' => 'tvs-audio', 'icon' => '📺'],
                ['name' => 'Cameras & Photography', 'slug' => 'cameras-photography', 'icon' => '📷'],
                ['name' => 'Gaming Consoles & Accessories', 'slug' => 'gaming-consoles-accessories', 'icon' => '🎮'],
                ['name' => 'Home Appliances', 'slug' => 'home-appliances', 'icon' => '🔌'],
                ['name' => 'Printers & Office Equipment', 'slug' => 'printers-office-equipment', 'icon' => '🖨️'],
            ],
        ],
        'property' => [
            'name' => 'Property',
            'slug' => 'property',
            'icon' => '🏠',
            'icon_bg' => 'bg-emerald-100 text-emerald-800',
            'subcategories' => [
                ['name' => 'Land & Plots', 'slug' => 'land-plots', 'icon' => '🏡'],
                ['name' => 'Houses For Sale', 'slug' => 'houses-for-sale', 'icon' => '🏘️'],
                ['name' => 'Apartments For Sale', 'slug' => 'apartments-for-sale', 'icon' => '🏢'],
                ['name' => 'Rooms For Rent', 'slug' => 'rooms-for-rent', 'icon' => '🏠'],
                ['name' => 'Offices & Commercial', 'slug' => 'offices-commercial', 'icon' => '🏢'],
                ['name' => 'Factories & Warehouses', 'slug' => 'factories-warehouses', 'icon' => '🏭'],
                ['name' => 'Farms & Agricultural Land', 'slug' => 'farms-agricultural-land', 'icon' => '🌾'],
            ],
        ],
        'home-garden' => [
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'icon' => '🏡',
            'icon_bg' => 'bg-teal-100 text-teal-800',
            'subcategories' => [
                ['name' => 'Furniture', 'slug' => 'furniture', 'icon' => '🛋️'],
                ['name' => 'Kitchen & Dining', 'slug' => 'kitchen-dining', 'icon' => '🍽️'],
                ['name' => 'Garden & Outdoor', 'slug' => 'garden-outdoor', 'icon' => '🌺'],
                ['name' => 'Bathroom & Plumbing', 'slug' => 'bathroom-plumbing', 'icon' => '🛁'],
                ['name' => 'Lighting & Electrical', 'slug' => 'lighting-electrical', 'icon' => '💡'],
                ['name' => 'Cleaning & Household Supplies', 'slug' => 'cleaning-household-supplies', 'icon' => '🧹'],
            ],
        ],
        'fashion-health-beauty' => [
            'name' => 'Fashion, Health & Beauty',
            'slug' => 'fashion-health-beauty',
            'icon' => '👗',
            'icon_bg' => 'bg-purple-100 text-purple-800',
            'subcategories' => [
                ['name' => "Men's Clothing", 'slug' => 'mens-clothing', 'icon' => '👔'],
                ['name' => "Women's Clothing", 'slug' => 'womens-clothing', 'icon' => '👗'],
                ['name' => "Kids' Clothing", 'slug' => 'kids-clothing', 'icon' => '👶'],
                ['name' => 'Shoes & Footwear', 'slug' => 'shoes-footwear', 'icon' => '👟'],
                ['name' => 'Beauty & Cosmetics', 'slug' => 'beauty-cosmetics', 'icon' => '💄'],
                ['name' => 'Health & Medical Supplies', 'slug' => 'health-medical-supplies', 'icon' => '💊'],
            ],
        ],
        'hobby-sport-kids' => [
            'name' => 'Hobby, Sport & Kids',
            'slug' => 'hobby-sport-kids',
            'icon' => '⚽',
            'icon_bg' => 'bg-orange-100 text-orange-800',
            'subcategories' => [
                ['name' => 'Sports Equipment', 'slug' => 'sports-equipment', 'icon' => '🎾'],
                ['name' => 'Art & Craft Supplies', 'slug' => 'art-craft-supplies', 'icon' => '🎨'],
                ['name' => "Kids' Toys & Games", 'slug' => 'kids-toys-games', 'icon' => '🧸'],
                ['name' => 'Musical Instruments', 'slug' => 'musical-instruments', 'icon' => '🎸'],
                ['name' => 'Books & Stationery', 'slug' => 'books-stationery', 'icon' => '📚'],
                ['name' => 'Hobbies & Collectibles', 'slug' => 'hobbies-collectibles', 'icon' => '🎯'],
            ],
        ],
        'business-industry' => [
            'name' => 'Business & Industry',
            'slug' => 'business-industry',
            'icon' => '🏭',
            'icon_bg' => 'bg-indigo-100 text-indigo-800',
            'subcategories' => [
                ['name' => 'Business Services', 'slug' => 'business-services', 'icon' => '🏢'],
                ['name' => 'Wholesale & Bulk Supplies', 'slug' => 'wholesale-bulk-supplies', 'icon' => '📦'],
                ['name' => 'Construction Materials', 'slug' => 'construction-materials', 'icon' => '🏗️'],
                ['name' => 'Agricultural Equipment', 'slug' => 'agricultural-equipment', 'icon' => '🚜'],
                ['name' => 'Restaurant & Hotel Supplies', 'slug' => 'restaurant-hotel-supplies', 'icon' => '🍳'],
                ['name' => 'Business Consulting', 'slug' => 'business-consulting', 'icon' => '📊'],
            ],
        ],
        'services' => [
            'name' => 'Services',
            'slug' => 'services',
            'icon' => '🔧',
            'icon_bg' => 'bg-cyan-100 text-cyan-800',
            'subcategories' => [
                ['name' => 'Repair Services', 'slug' => 'repair-services', 'icon' => '🛠️'],
                ['name' => 'Cleaning Services', 'slug' => 'cleaning-services', 'icon' => '🧹'],
                ['name' => 'Photography & Videography', 'slug' => 'photography-videography', 'icon' => '📸'],
                ['name' => 'Tutoring & Education', 'slug' => 'tutoring-education', 'icon' => '🎓'],
                ['name' => 'Financial Services', 'slug' => 'financial-services', 'icon' => '💰'],
                ['name' => 'Health & Wellness', 'slug' => 'health-wellness', 'icon' => '🏥'],
                ['name' => 'Transport & Moving Services', 'slug' => 'transport-moving-services', 'icon' => '🚚'],
                ['name' => 'Event & Party Services', 'slug' => 'event-party-services', 'icon' => '🎉'],
            ],
        ],
        'education' => [
            'name' => 'Education',
            'slug' => 'education',
            'icon' => '🎓',
            'icon_bg' => 'bg-violet-100 text-violet-800',
            'subcategories' => [
                ['name' => 'Courses & Classes', 'slug' => 'courses-classes', 'icon' => '📚'],
                ['name' => 'University Programs', 'slug' => 'university-programs', 'icon' => '🎓'],
                ['name' => 'Textbooks & Study Materials', 'slug' => 'textbooks-study-materials', 'icon' => '📖'],
                ['name' => 'Language Learning', 'slug' => 'language-learning', 'icon' => '🌍'],
                ['name' => 'Online Courses & Tutorials', 'slug' => 'online-courses-tutorials', 'icon' => '💻'],
                ['name' => 'Arts & Music Lessons', 'slug' => 'arts-music-lessons', 'icon' => '🎨'],
                ['name' => 'Exam Preparation', 'slug' => 'exam-preparation', 'icon' => '📝'],
            ],
        ],
        'animals' => [
            'name' => 'Animals',
            'slug' => 'animals',
            'icon' => '🐾',
            'icon_bg' => 'bg-rose-100 text-rose-800',
            'subcategories' => [
                ['name' => 'Dogs & Puppies', 'slug' => 'dogs-puppies', 'icon' => '🐶'],
                ['name' => 'Cats & Kittens', 'slug' => 'cats-kittens', 'icon' => '🐱'],
                ['name' => 'Birds', 'slug' => 'birds', 'icon' => '🐦'],
                ['name' => 'Fish & Aquariums', 'slug' => 'fish-aquariums', 'icon' => '🐠'],
                ['name' => 'Horses & Livestock', 'slug' => 'horses-livestock', 'icon' => '🐴'],
                ['name' => 'Pet Food & Supplies', 'slug' => 'pet-food-supplies', 'icon' => '🍖'],
            ],
        ],
    ];

    $initialCategory = request('category', '');
    $initialSubCategory = request('sub_category', '');
@endphp

<div
    x-data="{
        expandedCategory: @js($initialCategory),
        selectedCategory: @js($initialCategory),
        selectedSubCategory: @js($initialSubCategory),
        keyword: @js(request('search', '')),
        moreDetailsOpen: true,

        init() {
            // Sync with global category changes
            window.addEventListener('category-selected', (e) => {
                if (e.detail) {
                    this.selectedCategory = e.detail.category || '';
                    this.selectedSubCategory = e.detail.subCategory || '';
                    if (this.selectedCategory && !this.expandedCategory) {
                        this.expandedCategory = this.selectedCategory;
                    }
                }
            });

            // Sync with global keyword searches
            window.addEventListener('keyword-search', (e) => {
                if (e.detail && typeof e.detail.search !== 'undefined') {
                    this.keyword = e.detail.search;
                }
            });
        },

        toggleCategory(slug) {
            if (this.expandedCategory === slug) {
                this.expandedCategory = null;
            } else {
                this.expandedCategory = slug;
            }
        },

        selectCategory(slug, url) {
            this.selectedCategory = slug;
            this.selectedSubCategory = '';
            
            if (document.getElementById('home-listings-container')) {
                window.dispatchEvent(new CustomEvent('category-selected', {
                    detail: { category: slug, subCategory: '' }
                }));
                const container = document.getElementById('home-listings-container');
                if (container) {
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } else {
                window.location.href = url;
            }
        },

        selectSubCategory(catSlug, subSlug, url) {
            this.selectedCategory = catSlug;
            this.selectedSubCategory = subSlug;

            if (document.getElementById('home-listings-container')) {
                window.dispatchEvent(new CustomEvent('category-selected', {
                    detail: { category: catSlug, subCategory: subSlug }
                }));
                const container = document.getElementById('home-listings-container');
                if (container) {
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } else {
                window.location.href = url;
            }
        },

        submitKeywordSearch(fallbackUrl) {
            const query = this.keyword.trim();
            if (document.getElementById('home-listings-container')) {
                window.dispatchEvent(new CustomEvent('keyword-search', {
                    detail: { search: query }
                }));
                const container = document.getElementById('home-listings-container');
                if (container) {
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            } else {
                const u = new URL(fallbackUrl || window.location.href, window.location.origin);
                if (query) {
                    u.searchParams.set('search', query);
                } else {
                    u.searchParams.delete('search');
                }
                window.location.href = u.toString();
            }
        },

        clearKeywordSearch(fallbackUrl) {
            this.keyword = '';
            this.submitKeywordSearch(fallbackUrl);
        },

        clearAllFilters(resetUrl) {
            this.selectedCategory = '';
            this.selectedSubCategory = '';
            this.expandedCategory = null;
            this.keyword = '';

            if (document.getElementById('home-listings-container')) {
                window.dispatchEvent(new CustomEvent('category-selected', { detail: { category: '', subCategory: '' } }));
                window.dispatchEvent(new CustomEvent('keyword-search', { detail: { search: '' } }));
                window.dispatchEvent(new CustomEvent('location-selected', { detail: { location: '' } }));
            } else {
                window.location.href = resetUrl;
            }
        }
    }"
    class="bg-[#F9FAFB] rounded-2xl p-5 border border-slate-100 shadow-sm"
>
    <!-- Sidebar Header -->
    <div class="mb-5">
        <div class="flex items-center justify-between mb-1.5">
            <span class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-emerald-700">Find your next favourite</span>
            <span class="text-xs text-slate-500 font-semibold bg-white px-2 py-0.5 rounded-full border border-slate-100 shadow-2xs">10 Categories</span>
        </div>
        <h2 class="text-xl font-extrabold text-slate-900 leading-tight">Browse items<br>by category</h2>
    </div>

    <!-- Accordion Category List -->
    <ul class="space-y-1.5 overflow-y-auto max-h-[calc(100vh-320px)] no-scrollbar pb-3 pr-0.5" role="list">
        @foreach($categoryStructure as $catSlug => $item)
            @php
                $dbCat = $categories ? $categories->firstWhere('slug', $catSlug) : null;
                $displayTotal = number_format($dbCat?->listings_count ?? 0) . ' ads';
                $catUrl = route('home', ['category' => $catSlug]);
            @endphp
            <li class="rounded-xl border border-transparent transition-colors duration-150"
                :class="expandedCategory === '{{ $catSlug }}' ? 'bg-white/80 border-slate-200/80 shadow-2xs' : ''"
            >
                <!-- Main Category Accordion Header -->
                <div class="flex items-center justify-between p-2 rounded-xl transition duration-150 hover:bg-white"
                     :class="(selectedCategory === '{{ $catSlug }}' && !selectedSubCategory) ? 'bg-emerald-50/90 text-emerald-950 font-bold' : ''"
                >
                    <!-- Expand/Collapse Button (Category Icon + Name + Count) -->
                    <button
                        type="button"
                        @click="toggleCategory('{{ $catSlug }}')"
                        class="flex items-center gap-2.5 flex-1 text-left min-w-0 py-0.5 cursor-pointer select-none group"
                        :aria-expanded="expandedCategory === '{{ $catSlug }}'"
                    >
                        <!-- Category Icon Badge -->
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-base shadow-2xs transition-transform duration-150 group-hover:scale-105 {{ $item['icon_bg'] }}">
                            <span>{{ $item['icon'] }}</span>
                        </div>

                        <!-- Name and Count -->
                        <div class="flex-1 min-w-0 pr-1">
                            <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-emerald-700 truncate block transition-colors">
                                {{ $item['name'] }}
                            </span>
                            <span class="text-[11px] text-slate-400 font-medium block">
                                {{ $displayTotal }}
                            </span>
                        </div>
                    </button>

                    <!-- Chevron Toggle Icon -->
                    <button
                        type="button"
                        @click="toggleCategory('{{ $catSlug }}')"
                        aria-label="Toggle {{ $item['name'] }} subcategories"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-700 hover:bg-slate-100 transition-all duration-200 shrink-0 cursor-pointer"
                    >
                        <svg
                            class="w-4 h-4 transition-transform duration-200"
                            :class="expandedCategory === '{{ $catSlug }}' ? 'rotate-90 text-emerald-600' : 'text-slate-400'"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Subcategories Accordion Panel (Indented with smooth animation) -->
                <div
                    x-show="expandedCategory === '{{ $catSlug }}'"
                    x-collapse
                    x-cloak
                    class="overflow-hidden transition-all duration-200"
                >
                    <div class="pl-6 pr-2 py-2 my-1 border-l-2 border-emerald-200 ml-4.5 space-y-1">
                        <!-- 'All of [Category]' option to view entire main category -->
                        <a
                            href="{{ $catUrl }}"
                            @click.prevent="selectCategory('{{ $catSlug }}', '{{ $catUrl }}')"
                            class="flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-150 group cursor-pointer"
                            :class="(selectedCategory === '{{ $catSlug }}' && !selectedSubCategory)
                                ? 'bg-emerald-600 text-white shadow-2xs font-extrabold'
                                : 'text-emerald-800 hover:bg-emerald-50/80 hover:text-emerald-950'"
                        >
                            <span class="flex items-center gap-1.5">
                                <span class="text-xs">✨</span>
                                <span>All {{ $item['name'] }}</span>
                            </span>
                            <span class="text-[10px] opacity-80 uppercase tracking-wider font-semibold">View all</span>
                        </a>

                        <!-- Individual Subcategories -->
                        @foreach($item['subcategories'] as $sub)
                            @php
                                $subUrl = route('home', ['category' => $catSlug, 'sub_category' => $sub['slug']]);
                                $dbSub = ($dbCat && $dbCat->subCategories) ? $dbCat->subCategories->firstWhere('slug', $sub['slug']) : null;
                                $displaySubCount = number_format($dbSub?->listings_count ?? 0);
                            @endphp
                            <a
                                href="{{ $subUrl }}"
                                @click.prevent="selectSubCategory('{{ $catSlug }}', '{{ $sub['slug'] }}', '{{ $subUrl }}')"
                                class="flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs transition-all duration-150 group cursor-pointer"
                                :class="(selectedCategory === '{{ $catSlug }}' && selectedSubCategory === '{{ $sub['slug'] }}')
                                    ? 'bg-emerald-100 text-emerald-950 font-bold border border-emerald-300 shadow-2xs'
                                    : 'text-slate-600 hover:bg-white hover:text-emerald-800 hover:shadow-2xs'"
                            >
                                <div class="flex items-center gap-2 min-w-0 pr-1">
                                    <span class="text-sm shrink-0 transition-transform group-hover:scale-110">{{ $sub['icon'] }}</span>
                                    <span class="truncate">{{ $sub['name'] }}</span>
                                </div>
                                <span
                                    class="text-[11px] font-medium shrink-0 ml-1.5 transition-colors"
                                    :class="(selectedCategory === '{{ $catSlug }}' && selectedSubCategory === '{{ $sub['slug'] }}')
                                        ? 'text-emerald-800 font-bold'
                                        : 'text-slate-400 group-hover:text-slate-600'"
                                >
                                    ({{ $displaySubCount }})
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <!-- "More details" Keyword Search Feature -->
    <div class="mt-4 pt-4 border-t border-slate-200/80">
        <div class="bg-white rounded-xl p-3.5 border border-slate-200/70 shadow-2xs">
            <!-- Header with Icon & Accordion Toggle -->
            <button
                type="button"
                @click="moreDetailsOpen = !moreDetailsOpen"
                class="w-full flex items-center justify-between text-left cursor-pointer group"
                :aria-expanded="moreDetailsOpen"
            >
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-md bg-amber-50 text-amber-700 flex items-center justify-center text-xs font-bold shadow-2xs">
                        🔍
                    </div>
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-800 group-hover:text-emerald-700 transition-colors">
                        More details
                    </span>
                </div>
                <div class="flex items-center gap-1.5 text-slate-400">
                    <span class="text-[10px] uppercase font-bold text-slate-400 hidden sm:inline">Keywords</span>
                    <svg
                        class="w-3.5 h-3.5 transition-transform duration-200"
                        :class="moreDetailsOpen ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </button>

            <!-- Search Form Content -->
            <div x-show="moreDetailsOpen" x-collapse x-cloak class="mt-3">
                <p class="text-[11px] text-slate-500 mb-2 leading-relaxed">
                    Filter ads by specific features, brand, model, or keywords.
                </p>

                <form @submit.prevent="submitKeywordSearch('{{ route('listings.index') }}')" class="space-y-2">
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            x-model="keyword"
                            @keydown.enter.prevent="submitKeywordSearch('{{ route('listings.index') }}')"
                            placeholder="e.g. Toyota, automatic, pet..."
                            class="w-full rounded-lg border border-slate-300 bg-slate-50/50 py-1.5 pl-8 pr-7 text-xs text-slate-800 placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600"
                        >
                        <button
                            type="button"
                            x-show="keyword"
                            @click="clearKeywordSearch('{{ route('listings.index') }}')"
                            class="absolute inset-y-0 right-0 flex items-center pr-2 text-slate-400 hover:text-slate-700 cursor-pointer text-xs font-bold"
                            title="Clear keyword"
                        >
                            &times;
                        </button>
                    </div>

                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg bg-[#1E3A29] px-3 py-1.5 text-xs font-bold text-white shadow-2xs transition hover:bg-emerald-950 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-700 cursor-pointer"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Apply Keyword</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Active Filter Indicators & Clear All -->
    <div
        x-show="selectedCategory || selectedSubCategory || keyword"
        x-cloak
        class="mt-4 pt-3 border-t border-slate-200"
    >
        <button
            type="button"
            @click="clearAllFilters('{{ route('home') }}')"
            class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition cursor-pointer"
        >
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Clear Category &amp; Keywords</span>
        </button>
    </div>
</div>

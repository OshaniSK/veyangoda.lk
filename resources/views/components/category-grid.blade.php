<section class="mb-12">
    <div class="mb-6 flex items-end justify-between gap-4">
        <div>
            <p class="mb-1 text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">Find your next favourite</p>
            <h2 class="text-2xl font-bold text-slate-900 sm:text-3xl">Browse items by category</h2>
        </div>
        <span class="hidden text-sm text-slate-500 sm:block">{{ $categories->count() }} categories</span>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">
        @if(isset($categories))
            @foreach($categories as $category)
                @php
                    $isFoodAndFlavours = $category->slug === 'food-and-flavours';
                    $categoryName = strtolower($category->name);
                    $categoryIcon = match (true) {
                        str_contains($categoryName, 'handicraft'), str_contains($categoryName, 'art') => 'art',
                        str_contains($categoryName, 'decor'), str_contains($categoryName, 'home') => 'home',
                        str_contains($categoryName, 'food') => 'food',
                        str_contains($categoryName, 'textile'), str_contains($categoryName, 'handloom') => 'textile',
                        str_contains($categoryName, 'fashion'), str_contains($categoryName, 'beauty') => 'fashion',
                        str_contains($categoryName, 'essential') => 'essentials',
                        str_contains($categoryName, 'electronic') => 'electronics',
                        str_contains($categoryName, 'vehicle'), str_contains($categoryName, 'car') => 'vehicles',
                        str_contains($categoryName, 'property'), str_contains($categoryName, 'real estate') => 'property',
                        str_contains($categoryName, 'pet') => 'pets',
                        default => 'essentials',
                    };
                    $iconPalette = [
                        'art' => ['#DB2777', '#FBCFE8', '#7C3AED'],
                        'home' => ['#0F766E', '#99F6E4', '#F59E0B'],
                        'food' => ['#EA580C', '#FED7AA', '#65A30D'],
                        'textile' => ['#4F46E5', '#C7D2FE', '#EC4899'],
                        'fashion' => ['#C026D3', '#F5D0FE', '#0F766E'],
                        'essentials' => ['#0284C7', '#BAE6FD', '#F59E0B'],
                        'electronics' => ['#2563EB', '#BFDBFE', '#14B8A6'],
                        'vehicles' => ['#DC2626', '#FECACA', '#334155'],
                        'property' => ['#15803D', '#BBF7D0', '#F59E0B'],
                        'pets' => ['#9333EA', '#E9D5FF', '#F97316'],
                    ][$categoryIcon];
                @endphp
                <a href="{{ $isFoodAndFlavours ? route('categories.show', ['slug' => 'food-and-flavours']) : route('listings.category', ['category_slug' => $category->slug]) }}" class="group relative flex min-h-52 cursor-pointer flex-col items-center justify-center rounded-xl border border-slate-100 bg-white px-5 py-6 text-center shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-950/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
                    @if($isFoodAndFlavours)
                        <div class="absolute top-3 right-3 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-600 border border-emerald-100">
                            {{ $category->subCategories ? $category->subCategories->count() : '9' }} Sub-Categories
                        </div>
                    @endif
                    <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-50 transition-colors group-hover:bg-emerald-50">
                        @if($isFoodAndFlavours)
                            <span class="text-4xl">🍽️</span>
                        @else
                            <svg aria-hidden="true" class="h-14 w-14" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                @switch($categoryIcon)
                                    @case('art')
                                        <path d="M12 45c4-4 8-3 12 1l4 4c2 2 5 2 7 0l15-15-16-16-17 17c-3 3-4 6-5 9Z" fill="{{ $iconPalette[1] }}" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><path d="m30 21 8-8 13 13-8 8M14 47l-2 8 8-2M20 55l5-4M39 17l5-5 13 13-5 5" stroke="{{ $iconPalette[2] }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="22" cy="27" r="2" fill="{{ $iconPalette[0] }}"/>
                                        @break
                                    @case('home')
                                        <path d="m8 30 24-20 24 20" stroke="{{ $iconPalette[0] }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 27v27h36V27L32 12 14 27Z" fill="{{ $iconPalette[1] }}" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><path d="M27 54V38h10v16M43 34h1" stroke="{{ $iconPalette[2] }}" stroke-width="2.5" stroke-linecap="round"/><path d="M10 48c-2-7 2-12 7-13 1 6-1 11-7 13ZM10 48c2-4 4-6 7-8" stroke="{{ $iconPalette[2] }}" stroke-width="2" stroke-linecap="round"/>
                                        @break
                                    @case('textile')
                                        <path d="M14 11v42M50 11v42M10 15h44M10 49h44" stroke="{{ $iconPalette[0] }}" stroke-width="3" stroke-linecap="round"/><path d="M19 20v24m6-24v24m6-24v24m6-24v24m6-24v24" stroke="{{ $iconPalette[2] }}" stroke-width="2.5"/><path d="M18 24h28M18 31h28M18 38h28" stroke="{{ $iconPalette[1] }}" stroke-width="4" stroke-linecap="round"/><path d="m21 24 4 7-4 7m8-14 4 7-4 7m8-14 4 7-4 7" stroke="{{ $iconPalette[0] }}" stroke-width="1.5"/>
                                        @break
                                    @case('fashion')
                                        <path d="m25 14 7-4 7 4 8 10-7 5-4-5v28H20V24l-4 5-7-5 8-10 8-4Z" fill="{{ $iconPalette[1] }}" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><path d="M27 13c0 4 2 6 5 6s5-2 5-6M32 19v33" stroke="{{ $iconPalette[2] }}" stroke-width="2.5" stroke-linecap="round"/><path d="m47 12 7 7-17 17-7-7 17-17ZM49 10l3-3 7 7-3 3" fill="{{ $iconPalette[2] }}" stroke="{{ $iconPalette[0] }}" stroke-width="1.5" stroke-linejoin="round"/>
                                        @break
                                    @case('essentials')
                                        <path d="M11 27h42l-4 27H15l-4-27Z" fill="{{ $iconPalette[1] }}" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><path d="M19 27c0-8 5-13 13-13s13 5 13 13M8 27h48" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linecap="round"/><path d="M24 38h16M27 44h10" stroke="{{ $iconPalette[2] }}" stroke-width="3" stroke-linecap="round"/>
                                        @break
                                    @case('electronics')
                                        <rect x="6" y="13" width="37" height="28" rx="3" fill="{{ $iconPalette[1] }}" stroke="{{ $iconPalette[0] }}" stroke-width="2.5"/><path d="M3 46h43l-4 5H8l-5-5ZM17 47h14" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><rect x="44" y="22" width="14" height="29" rx="3" fill="white" stroke="{{ $iconPalette[2] }}" stroke-width="2.5"/><path d="M49 26h4M50 46h2" stroke="{{ $iconPalette[0] }}" stroke-width="2" stroke-linecap="round"/>
                                        @break
                                    @case('vehicles')
                                        <path d="m8 37 4-12h29l7 12v9H8v-9Z" fill="{{ $iconPalette[1] }}" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><path d="m16 25 4-8h13l5 8M9 36h38" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><circle cx="17" cy="45" r="4" fill="white" stroke="{{ $iconPalette[2] }}" stroke-width="2.5"/><circle cx="39" cy="45" r="4" fill="white" stroke="{{ $iconPalette[2] }}" stroke-width="2.5"/><circle cx="19" cy="14" r="5" stroke="{{ $iconPalette[2] }}" stroke-width="2.5"/><circle cx="46" cy="14" r="5" stroke="{{ $iconPalette[2] }}" stroke-width="2.5"/><path d="m19 14 8-3 5 4 7-1m-12 0 3 5" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        @break
                                    @case('property')
                                        <path d="m8 29 24-20 24 20" stroke="{{ $iconPalette[0] }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 27v27h36V27L32 12 14 27Z" fill="{{ $iconPalette[1] }}" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><path d="M27 54V39h10v15" stroke="{{ $iconPalette[2] }}" stroke-width="2.5" stroke-linejoin="round"/><circle cx="45" cy="42" r="5" fill="white" stroke="{{ $iconPalette[2] }}" stroke-width="2.5"/><path d="M45 47v7h5" stroke="{{ $iconPalette[2] }}" stroke-width="2.5" stroke-linecap="round"/>
                                        @break
                                    @default
                                        <path d="M7 28 5 16l12 6c4-2 9-2 13 0v20c-4 5-17 5-21 0-4-4-5-9-2-14Z" fill="{{ $iconPalette[1] }}" stroke="{{ $iconPalette[0] }}" stroke-width="2.5" stroke-linejoin="round"/><path d="m35 22 1-12 9 7 10-6-1 14c4 5 3 13-2 17-5 5-16 4-20-1-4-5-3-14 3-19Z" fill="white" stroke="{{ $iconPalette[2] }}" stroke-width="2.5" stroke-linejoin="round"/><circle cx="15" cy="32" r="1.8" fill="{{ $iconPalette[0] }}"/><circle cx="24" cy="32" r="1.8" fill="{{ $iconPalette[0] }}"/><path d="M16 38c2 2 5 2 7 0m17-4h.01m9 0h.01m-8 5 2 2 2-2" stroke="{{ $iconPalette[0] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                @endswitch
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-base font-bold text-slate-900 transition-colors group-hover:text-emerald-800">{{ $category->name }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $category->listings_count }} {{ $category->listings_count === 1 ? 'ad' : 'ads' }}</p>
                </a>
            @endforeach
        @endif
    </div>
</section>

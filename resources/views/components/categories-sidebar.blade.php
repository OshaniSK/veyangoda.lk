@props(['categories'])

<div class="bg-[#F9FAFB] rounded-2xl p-5 border border-slate-100">
    <div class="mb-5">
        <div class="flex items-center justify-between mb-1">
            <span class="text-[10px] font-bold uppercase tracking-[0.16em] text-emerald-700">Find your next favourite</span>
            <span class="text-xs text-slate-500 font-medium">{{ $categories->count() }} categories</span>
        </div>
        <h2 class="text-xl font-extrabold text-slate-900">Browse items<br>by category</h2>
    </div>

    <ul class="space-y-1.5 overflow-y-auto max-h-[calc(100vh-250px)] no-scrollbar pb-4 pr-1">
        @foreach($categories as $category)
            @php
                $isActive = request('category') === $category->slug;
                
                // Determine Icon Colors (similar to old grid)
                $categoryName = strtolower($category->name);
                $color = match (true) {
                    str_contains($categoryName, 'electronic') => 'text-blue-500 bg-blue-50',
                    str_contains($categoryName, 'fashion'), str_contains($categoryName, 'beauty') => 'text-purple-500 bg-purple-50',
                    str_contains($categoryName, 'decor'), str_contains($categoryName, 'home') => 'text-green-500 bg-green-50',
                    str_contains($categoryName, 'food') => 'text-orange-500 bg-orange-50',
                    str_contains($categoryName, 'vehicle'), str_contains($categoryName, 'car') => 'text-red-500 bg-red-50',
                    str_contains($categoryName, 'property') => 'text-emerald-500 bg-emerald-50',
                    str_contains($categoryName, 'pet') => 'text-pink-500 bg-pink-50',
                    str_contains($categoryName, 'art') => 'text-rose-500 bg-rose-50',
                    default => 'text-slate-500 bg-slate-100',
                };
            @endphp
            <li>
                <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug, 'page' => null]) }}" 
                   class="flex items-center gap-3 p-2.5 rounded-xl transition-all duration-200 
                          {{ $isActive ? 'bg-emerald-50 border-l-4 border-emerald-500 pl-2 shadow-sm' : 'hover:bg-white hover:shadow-sm border-l-4 border-transparent pl-2' }}">
                    
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 {{ $isActive ? 'bg-emerald-100 text-emerald-600' : $color }}">
                        <!-- Fallback icon (user can customize per category) -->
                        @if($category->slug === 'food-and-flavours')
                            <span class="text-xl">🍽️</span>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        @endif
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-bold text-slate-900 truncate">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500">{{ $category->listings_count }} {{ $category->listings_count === 1 ? 'ad' : 'ads' }}</p>
                    </div>

                    @if($category->subCategories->count() > 0)
                        <span class="shrink-0 bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">
                            Sub-Categories
                        </span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
    
    @if(request()->has('category'))
        <div class="mt-4 pt-4 border-t border-slate-200">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-800 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Clear Category Filter
            </a>
        </div>
    @endif
</div>

@props(['listing', 'layout' => 'grid'])

@if($layout === 'grid')
    <a href="{{ route('listings.show', $listing->slug) }}" class="group flex flex-col overflow-hidden rounded-xl border border-[#E5E5E5] bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md h-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
        <div class="aspect-[4/3] w-full overflow-hidden bg-slate-100">
            <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
        </div>
        <div class="flex flex-1 flex-col p-4">
            <h3 class="mb-1 line-clamp-2 text-sm font-bold text-slate-900 transition-colors group-hover:text-emerald-800" title="{{ $listing->title }}">{{ $listing->title }}</h3>
            <p class="mb-2 text-lg font-bold text-[#008060]">Rs {{ number_format($listing->price, 2) }}</p>
            <div class="mt-auto flex items-center justify-between text-xs text-slate-500">
                <span class="flex items-center gap-1">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $listing->location }}
                </span>
                <span>{{ $listing->created_at->diffForHumans(null, true) }}</span>
            </div>
        </div>
    </a>
@else
    <a href="{{ route('listings.show', $listing->slug) }}" class="group flex flex-row overflow-hidden rounded-xl border border-[#E5E5E5] bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
        <div class="w-1/3 sm:w-1/4 aspect-[4/3] overflow-hidden bg-slate-100 shrink-0">
            <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
        </div>
        <div class="flex flex-1 flex-col p-4 sm:p-5">
            <div class="flex justify-between items-start gap-4">
                <h3 class="mb-1 line-clamp-2 text-base sm:text-lg font-bold text-slate-900 transition-colors group-hover:text-emerald-800">{{ $listing->title }}</h3>
                <p class="text-base sm:text-xl font-bold text-[#008060] whitespace-nowrap">Rs {{ number_format($listing->price, 2) }}</p>
            </div>
            
            @if($listing->description)
                <p class="mt-2 text-sm text-slate-600 line-clamp-2 hidden sm:block">{{ $listing->description }}</p>
            @endif
            
            <div class="mt-auto pt-4 flex items-center justify-between text-xs sm:text-sm text-slate-500">
                <span class="flex items-center gap-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $listing->location }}
                </span>
                <span>{{ $listing->created_at->diffForHumans(null, true) }}</span>
            </div>
        </div>
    </a>
@endif

@props(['listing'])

@php
    // Handle image path whether stored locally in public disk or external URL
    $imageSrc = 'https://images.unsplash.com/photo-1584992236310-6edddc08acff?auto=format&fit=crop&w=600&q=80';
    if (!empty($listing->image_path)) {
        $imageSrc = str_starts_with($listing->image_path, 'http')
            ? $listing->image_path
            : asset('storage/' . $listing->image_path);
    }

    // Status badge class mapping
    $statusClass = match(strtolower($listing->status ?? 'active')) {
        'active'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'pending' => 'bg-amber-50  text-amber-700  border-amber-200',
        'closed'  => 'bg-rose-50   text-rose-700   border-rose-200',
        default   => 'bg-slate-50  text-slate-600  border-slate-200',
    };
@endphp

{{-- ── Card: white, rounded-2xl, lifts on hover ── --}}
<article {{ $attributes->merge(['class' =>
    'group relative flex flex-col bg-white rounded-2xl
     border border-slate-200/80 shadow-sm
     hover:shadow-xl hover:shadow-slate-900/8
     hover:-translate-y-1 hover:border-brand-blue/30
     transition-all duration-300 overflow-hidden'
]) }}>

    {{-- ── Card Image (1:1 aspect) ── --}}
    <div class="relative w-full aspect-square bg-slate-100 overflow-hidden">
        <a href="{{ route('listings.show', $listing->slug) }}" class="block w-full h-full">
            <img
                src="{{ $imageSrc }}"
                alt="{{ $listing->title }}"
                loading="lazy"
                class="w-full h-full object-cover object-center
                       group-hover:scale-105 transition-transform duration-500 ease-out"
            />
        </a>

        {{-- ── Category Badge (top-left) ── --}}
        <div class="absolute top-2.5 left-2.5 z-10 pointer-events-none">
            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold
                         bg-slate-900/75 backdrop-blur-md text-white shadow-xs tracking-tight">
                {{ $listing->category->name ?? 'Domestic' }}
            </span>
        </div>

        {{-- ── Handmade Certified Badge (top-right) ── --}}
        @if($listing->user?->is_artisan_certified)
            <div class="absolute top-2.5 right-2.5 z-10 pointer-events-none">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold
                             backdrop-blur-md text-white shadow-xs"
                      style="background: linear-gradient(135deg,#6C2BD9,#2563EB);">
                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span>Handmade</span>
                </span>
            </div>
        @endif
    </div>

    {{-- ── Card Content Body ── --}}
    <div class="flex flex-col flex-1 p-3.5 sm:p-4">

        {{-- Price — large, brand-colored ── --}}
        <div class="text-base sm:text-lg font-extrabold tracking-tight text-slate-900 font-serif mb-1 leading-snug">
            {{ $listing->formatted_price }}
        </div>

        {{-- Title (2 lines max) ── --}}
        <h3 class="text-xs sm:text-sm font-semibold text-slate-800 line-clamp-2 leading-snug
                   group-hover:text-brand-blue transition-colors duration-200 mb-2.5">
            <a href="{{ route('listings.show', $listing->slug) }}">
                {{ $listing->title }}
            </a>
        </h3>

        {{-- ── Metadata: Location & Timestamp ── --}}
        <div class="mt-auto pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
            <div class="flex items-center gap-1 min-w-0 pr-1">
                <svg class="w-3.5 h-3.5 text-brand-blue/60 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="truncate font-medium text-slate-600">{{ $listing->location }}</span>
            </div>

            <span class="shrink-0 text-slate-400">
                {{ $listing->created_at->diffForHumans(short: true) }}
            </span>
        </div>
    </div>
</article>

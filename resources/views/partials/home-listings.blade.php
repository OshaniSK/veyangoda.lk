{{--
    Partial: home-listings.blade.php
    Rendered server-side and returned as JSON { html } for AJAX requests
    from the home page (welcome.blade.php).
--}}
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

    <div class="mt-8 ajax-pagination">
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

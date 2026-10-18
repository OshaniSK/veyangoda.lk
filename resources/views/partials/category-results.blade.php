{{--
    Partial: category-results.blade.php
    Server-rendered HTML returned as JSON { html } for AJAX on listings/category page.
--}}
<div class="mb-5 flex flex-wrap items-center justify-between gap-2">
    <p class="text-sm text-slate-600" aria-live="polite">
        Showing <span class="font-bold text-slate-900">{{ $listings->total() }}</span>
        results for <span class="font-semibold text-slate-900">{{ $category->name }}</span>
    </p>
    <span class="text-xs text-slate-500">{{ $listings->firstItem() ?? 0 }}&ndash;{{ $listings->lastItem() ?? 0 }} of {{ $listings->total() }}</span>
</div>

@if($listings->isNotEmpty())
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($listings as $listing)
            <x-listing-card :listing="$listing" />
        @endforeach
    </div>
    <div class="mt-8 ajax-pagination">{{ $listings->links() }}</div>
@else
    <div class="rounded-2xl border border-slate-200 bg-white px-5 py-14 text-center shadow-sm sm:px-10">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-50 text-green-800">
            <svg aria-hidden="true" class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 8.5 12 4l9 4.5v10L12 23l-9-4.5v-10Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m3.5 8.8 8.5 4.3 8.5-4.3M12 13v9.5"/></svg>
        </div>
        <h2 class="text-xl font-extrabold text-slate-900">No {{ strtolower($category->name) }} found matching your criteria.</h2>
        <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-600">Try clearing some filters or check back later.</p>
        <a href="{{ route('listings.category', $category->slug) }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-green-100 px-6 py-3 font-bold text-green-900 shadow-sm transition hover:bg-green-200 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-600 focus-visible:ring-offset-2">Clear Filters</a>
    </div>
@endif

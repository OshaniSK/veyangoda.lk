<x-app-layout>
    <main class="bg-[#F8FAFC] py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-5 flex text-sm text-slate-500">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-emerald-700 hover:underline">Home</a></li>
                    <li><span aria-hidden="true" class="mx-1.5 opacity-50">&rsaquo;</span></li>
                    <li><a href="{{ route('listings.index') }}" class="hover:text-emerald-700 hover:underline">All Categories</a></li>
                    <li><span aria-hidden="true" class="mx-1.5 opacity-50">&rsaquo;</span></li>
                    <li class="font-semibold text-slate-900" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>

            <header class="mb-6 sm:mb-10">
                <h1 class="text-3xl font-extrabold text-slate-900 sm:text-4xl md:text-5xl">Find The Best {{ $category->name }} For You</h1>
            </header>

            <section class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6 lg:p-8" aria-labelledby="filter-heading">
                <h2 id="filter-heading" class="sr-only">Filter {{ $category->name }}</h2>
                <form method="GET" action="{{ route('listings.category', $category->slug) }}" class="space-y-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($filters as $filter)
                            <div class="relative">
                                <label for="filter_{{ $filter->filter_name }}" class="mb-1.5 block text-sm font-bold text-slate-700 capitalize">{{ str_replace('_', ' ', $filter->filter_name) }}</label>
                                
                                @if($filter->filter_type === 'dropdown')
                                    <div class="relative">
                                        <select id="filter_{{ $filter->filter_name }}" name="{{ $filter->filter_name }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                                            <option value="">Any {{ str_replace('_', ' ', $filter->filter_name) }}</option>
                                            @foreach($filter->options as $option)
                                                <option value="{{ $option->option_value }}" {{ request($filter->filter_name) == $option->option_value ? 'selected' : '' }}>
                                                    {{ $option->option_value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif($filter->filter_type === 'text')
                                    <input type="text" id="filter_{{ $filter->filter_name }}" name="{{ $filter->filter_name }}" value="{{ request($filter->filter_name) }}" placeholder="{{ $filter->placeholder ?? 'Enter ' . str_replace('_', ' ', $filter->filter_name) }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                                @elseif($filter->filter_type === 'number')
                                    <input type="number" id="filter_{{ $filter->filter_name }}" name="{{ $filter->filter_name }}" value="{{ request($filter->filter_name) }}" placeholder="{{ $filter->placeholder ?? 'e.g. 1000' }}" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-6 py-3.5 text-base font-bold text-white transition hover:bg-green-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-700 focus-visible:ring-offset-2">
                        <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Search {{ $category->name }}
                    </button>
                </form>
            </section>

            <section aria-label="Listing results">
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
                    <div class="mt-8">{{ $listings->links() }}</div>
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
            </section>
        </div>
    </main>
</x-app-layout>

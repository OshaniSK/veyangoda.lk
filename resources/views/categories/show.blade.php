<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8 flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-emerald-700">
                        <svg class="mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="mx-1 h-6 w-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-slate-700 md:ml-2">{{ $category->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="mb-10 text-center sm:text-left">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="mt-3 max-w-2xl text-base text-slate-500 sm:text-lg sm:mx-0 mx-auto">
                    {{ $category->description }}
                </p>
            @endif
        </div>

        @if($category->subCategories->count() > 0)
            <section class="mb-12">
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach($category->subCategories as $subCategory)
                        <a href="{{ route('listings.sub_category', ['category_slug' => $category->slug, 'sub_category_slug' => $subCategory->slug]) }}" class="group flex cursor-pointer flex-col items-center justify-center rounded-xl border border-slate-100 bg-white px-4 py-6 text-center shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md hover:shadow-emerald-950/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600">
                            <span class="mb-3 block text-4xl transition-transform group-hover:scale-110">{{ $subCategory->icon ?? '🍽️' }}</span>
                            <h3 class="text-sm font-bold text-slate-900 transition-colors group-hover:text-emerald-800">{{ $subCategory->name }}</h3>
                            <p class="mt-1 text-xs text-slate-500">{{ $subCategory->listings_count ?? 0 }} {{ ($subCategory->listings_count ?? 0) === 1 ? 'ad' : 'ads' }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
        
        <div class="mt-10 flex justify-center sm:justify-start">
            <a href="{{ route('listings.category', ['category_slug' => $category->slug]) }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-6 py-3.5 font-bold text-white shadow-sm transition hover:bg-emerald-700 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2">
                View All {{ $category->name }} Ads
                <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</x-app-layout>

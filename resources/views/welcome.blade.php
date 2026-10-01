<x-app-layout>
    <!-- A. Hero Header (Extends the Teal/Green Navbar) -->
    <div class="bg-primary pt-8 pb-12 sm:pt-12 sm:pb-16 text-center shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                Welcome to Veyangoda.lk
            </h1>
            <p class="text-green-100 text-lg sm:text-xl font-medium max-w-2xl mx-auto mb-8">
                Buy and sell everything from homemade food to real estate safely in Sri Lanka.
            </p>

            <!-- Search Form -->
            <form action="{{ route('home') }}" method="GET" class="max-w-4xl mx-auto flex flex-col md:flex-row gap-2 px-4">
                <input type="text" name="search" placeholder="What are you looking for?" value="{{ request('search') }}" class="flex-1 px-4 py-3 rounded-lg border-none focus:ring-2 focus:ring-yellow-400 text-gray-900 shadow-sm">
                
                <div class="relative flex-1 md:flex-none md:w-64">
                    <select name="location" class="w-full px-4 py-3 rounded-lg border-none focus:ring-2 focus:ring-yellow-400 text-gray-900 appearance-none bg-white pr-10 shadow-sm">
                        <option value="">Select District/City</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                        @endforeach
                    </select>
                    <!-- subtle arrow icon -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>

                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold px-6 py-3 rounded-lg transition-colors flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- B. Category Grid -->
        <div class="mb-12">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Browse items by category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('listings.index', ['category_id' => $category->id]) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md p-4 flex flex-col items-center justify-center text-center gap-3 transition-all transform hover:scale-105 border border-gray-100 group">
                        <!-- Dynamic Category Icon -->
                        <div class="w-16 h-16 rounded-full bg-green-50 text-primary flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            @php
                                $cat = strtolower($category->name);
                            @endphp
                            @if(str_contains($cat, 'food'))
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            @elseif(str_contains($cat, 'electronic'))
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            @elseif(str_contains($cat, 'property') || str_contains($cat, 'real estate') || str_contains($cat, 'home'))
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            @elseif(str_contains($cat, 'vehicle') || str_contains($cat, 'car') || str_contains($cat, 'auto'))
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            @elseif(str_contains($cat, 'job'))
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">{{ $category->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $category->listings_count }} ads</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- C. Featured Ads Carousel -->
        @if($listings->count() > 0)
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Featured Ads</h2>
                <a href="{{ route('listings.index') }}" class="text-sm font-semibold text-primary hover:underline">View All</a>
            </div>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 no-scrollbar">
                @foreach($listings->take(6) as $listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="snap-start shrink-0 w-64 sm:w-72 bg-white rounded-xl shadow-sm hover:shadow-md overflow-hidden transition-shadow border border-gray-100 flex flex-col group">
                        <div class="aspect-[4/3] w-full bg-gray-100 overflow-hidden relative">
                            <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @if($listing->status === 'sold')
                                <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-wider">Sold</div>
                            @endif
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-900 text-sm line-clamp-2 mb-1 group-hover:text-primary transition-colors">{{ $listing->title }}</h3>
                            <p class="font-bold text-primary text-base mb-2">Rs {{ number_format($listing->price, 2) }}</p>
                            <div class="mt-auto flex items-center justify-between text-xs text-gray-500">
                                <span>{{ $listing->location }}</span>
                                <span>{{ $listing->created_at->diffForHumans(null, true) }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- D. Call to Action (CTA) Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <!-- Primary CTA -->
            <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8 flex items-center justify-between border-l-4 border-yellow-400">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Start making money!</h3>
                    <p class="text-sm text-gray-600 mb-4">Do you have something to sell? Post your first ad for free.</p>
                    <a href="{{ route('listings.create') }}" class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-2.5 px-6 rounded-full shadow-sm transition-colors text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Post your ad for free
                    </a>
                </div>
                <div class="hidden sm:block">
                    <!-- Icon graphic -->
                    <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center text-yellow-500">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
            </div>

            <!-- Secondary CTA -->
            <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8 flex items-center justify-between border-l-4 border-primary">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Find Jobs & Serendipity</h3>
                    <p class="text-sm text-gray-600 mb-4">Looking for a job or offering a service? Check our specialized categories.</p>
                    <a href="{{ route('listings.index') }}" class="inline-flex items-center justify-center bg-primary hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-full shadow-sm transition-colors text-sm">
                        Browse Services
                    </a>
                </div>
                <div class="hidden sm:block">
                    <!-- Icon graphic -->
                    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center text-primary">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- E. Seller Conversion Banner -->
        <div class="mb-12 rounded-2xl overflow-hidden shadow-lg bg-gradient-to-r from-[#6C2BD9] via-[#2563EB] to-[#06B6D4] text-white p-8 sm:p-12 text-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Ready to sell? Post your ad in seconds.</h2>
            <p class="text-lg sm:text-xl font-medium mb-8 text-blue-100">Join thousands of sellers on Veyangoda.lk.</p>
            <a href="{{ Auth::check() ? route('listings.create') : url('/login?redirect=/listings/create') }}" class="inline-block bg-white text-transparent bg-clip-text bg-gradient-to-r from-[#6C2BD9] to-[#06B6D4] font-bold text-lg px-8 py-3 rounded-full hover:scale-105 transition-transform shadow-xl">
                Post an Ad
            </a>
        </div>

    </div>

    <!-- Optional: Add a custom style block for scrollbar hiding -->
    @slot('header')
    @endslot
    
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>

<x-app-layout>
    <!-- A. Hero Header (Extends the Teal/Green Navbar) -->
    <div class="bg-primary pt-8 pb-12 sm:pt-12 sm:pb-16 text-center shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight mb-4">
                Welcome to Veyangoda.lk
            </h1>
            <p class="text-green-100 text-lg sm:text-xl font-medium max-w-2xl mx-auto">
                Buy and sell everything from homemade food to real estate safely in Sri Lanka.
            </p>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- B. Category Grid -->
        <div class="mb-12">
            <h2 class="text-xl sm:text-2xl font-bold text-dark mb-6">Browse items by category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('listings.index', ['category_id' => $category->id]) }}" class="bg-white rounded-xl shadow-card hover:shadow-card-hover p-4 flex items-center gap-4 transition-shadow border border-gray-100">
                        <!-- Category Icon (Placeholder or dynamic) -->
                        <div class="w-12 h-12 rounded-full bg-secondary text-primary flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-dark text-sm sm:text-base">{{ $category->name }}</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $category->listings_count }} ads</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- C. Featured Ads Carousel -->
        @if($listings->count() > 0)
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-dark">Featured Ads</h2>
                <a href="{{ route('listings.index') }}" class="text-sm font-semibold text-primary hover:underline">View All</a>
            </div>
            
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 no-scrollbar">
                @foreach($listings->take(6) as $listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="snap-start shrink-0 w-64 sm:w-72 bg-white rounded-xl shadow-card hover:shadow-card-hover overflow-hidden transition-shadow border border-gray-100 flex flex-col group">
                        <div class="aspect-[4/3] w-full bg-gray-100 overflow-hidden relative">
                            <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @if($listing->status === 'sold')
                                <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-sm uppercase tracking-wider">Sold</div>
                            @endif
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-dark text-sm line-clamp-2 mb-1 group-hover:text-primary transition-colors">{{ $listing->title }}</h3>
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
            <div class="bg-white rounded-2xl shadow-card p-6 sm:p-8 flex items-center justify-between border-l-4 border-yellow-400">
                <div>
                    <h3 class="text-xl font-bold text-dark mb-2">Start making money!</h3>
                    <p class="text-sm text-gray-600 mb-4">Do you have something to sell? Post your first ad for free.</p>
                    <a href="{{ route('listings.create') }}" class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-2.5 px-6 rounded-full shadow-md transition-colors text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Post your ad for free
                    </a>
                </div>
                <div class="hidden sm:block">
                    <!-- Icon graphic -->
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-500">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
            </div>

            <!-- Secondary CTA -->
            <div class="bg-white rounded-2xl shadow-card p-6 sm:p-8 flex items-center justify-between border-l-4 border-primary">
                <div>
                    <h3 class="text-xl font-bold text-dark mb-2">Find Jobs & Serendipity</h3>
                    <p class="text-sm text-gray-600 mb-4">Looking for a job or offering a service? Check our specialized categories.</p>
                    <a href="{{ route('listings.index') }}" class="inline-flex items-center justify-center bg-primary hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-full shadow-md transition-colors text-sm">
                        Browse Services
                    </a>
                </div>
                <div class="hidden sm:block">
                    <!-- Icon graphic -->
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-primary">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" /></svg>
                    </div>
                </div>
            </div>
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

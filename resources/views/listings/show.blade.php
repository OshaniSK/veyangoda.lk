<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
            <span>/</span>
            <span class="text-gray-700 font-semibold">{{ $listing->category->name }}</span>
            <span>/</span>
            <span class="text-gray-900 truncate max-w-xs">{{ $listing->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: Image & Description (Span 8) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Image Box -->
                <div class="bg-white rounded-xl shadow-card overflow-hidden border border-gray-100 relative">
                    <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" class="w-full h-auto max-h-[500px] object-contain bg-gray-50">
                    
                    @if(strtolower($listing->status) !== 'active')
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                {{ $listing->status }}
                            </span>
                        </div>
                    @endif
                </div>

                @if($listing->images->count() > 1)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($listing->images->skip(1) as $image)
                            <img src="{{ $image->url }}" alt="{{ $listing->title }}" loading="lazy" class="w-full aspect-square rounded-lg object-cover border border-gray-100">
                        @endforeach
                    </div>
                @endif

                <!-- Description Box -->
                <div class="bg-white rounded-xl shadow-card border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-dark mb-4 border-b border-gray-100 pb-2">Description</h2>
                    <div class="prose text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ $listing->description }}
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Price & Seller Info (Span 4) -->
            <div class="lg:col-span-4 space-y-6 sticky top-24">
                
                <!-- Price & Title Card -->
                <div class="bg-white rounded-xl shadow-card border border-gray-100 p-6">
                    <p class="text-3xl font-extrabold text-primary mb-2">Rs {{ number_format($listing->price, 2) }}</p>
                    <h1 class="text-xl font-bold text-dark leading-tight">{{ $listing->title }}</h1>
                    
                    <div class="mt-4 flex items-center text-xs text-gray-500 gap-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $listing->created_at->diffForHumans() }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $listing->location }}
                        </span>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-6">
                        <button
                            type="button"
                            @click="$dispatch('open-contact-modal', {
                                listingId: {{ $listing->id }},
                                title: '{{ addslashes($listing->title) }}',
                                price: '{{ $listing->price }}',
                                phone: '{{ $listing->user?->phone_number ?: ($listing->user?->phone ?: 'Hidden') }}',
                                sellerName: '{{ addslashes($listing->user?->name ?? 'User') }}',
                                sellerId: {{ $listing->user_id }},
                                isAuth: {{ auth()->check() ? 'true' : 'false' }}
                            })"
                            class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-lg bg-primary hover:bg-green-700 text-white font-bold text-base shadow-md transition-colors"
                        >
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Contact Seller</span>
                        </button>
                    </div>
                </div>

                <!-- Seller Info Card -->
                <div class="bg-white rounded-xl shadow-card border border-gray-100 p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Seller Information</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-full bg-gray-100 text-primary flex items-center justify-center font-bold text-xl shrink-0">
                            {{ strtoupper(substr($listing->user?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-dark text-base">{{ $listing->user?->name ?? 'Private Seller' }}</h4>
                            <p class="text-xs text-gray-500">Member since {{ $listing->user?->created_at->format('M Y') ?? 'Recently' }}</p>
                        </div>
                    </div>
                    
                    <a href="#" class="block text-center text-sm font-semibold text-primary hover:underline bg-secondary py-2 rounded-md">
                        View Seller Profile
                    </a>
                </div>

                <!-- Safety Tips Card -->
                <div class="bg-white rounded-xl shadow-card border border-gray-100 p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Safety Tips</h3>
                    <ul class="text-xs text-gray-600 space-y-2 list-disc pl-4">
                        <li>Avoid sending money in advance.</li>
                        <li>Meet the seller in a safe, public location.</li>
                        <li>Inspect the item before you buy it.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Contact Modal Component -->
    <x-contact-modal />
</x-app-layout>

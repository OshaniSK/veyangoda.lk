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
                <!-- Image Gallery Grid -->
                <div class="bg-white rounded-xl shadow-card overflow-hidden border border-gray-100 relative p-4 sm:p-6">
                    @if($listing->photos->count() > 0)
                        <div class="grid gap-3 grid-cols-1 sm:grid-cols-2 @if($listing->photos->count() > 2) md:grid-cols-3 @endif">
                            @foreach($listing->photos as $index => $photo)
                                <a href="{{ Storage::url($photo->photo_path) }}" target="_blank" class="block overflow-hidden rounded-lg shadow-sm border border-gray-100 hover:opacity-90 transition-opacity @if($index === 0 && $listing->photos->count() % 2 !== 0 && $listing->photos->count() !== 3) sm:col-span-2 md:col-span-1 @endif @if($index === 0 && $listing->photos->count() === 3) sm:col-span-2 md:col-span-2 @endif">
                                    <img src="{{ Storage::url($photo->photo_path) }}" alt="{{ $listing->title }} - Photo" loading="lazy" class="w-full aspect-square object-cover">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" loading="lazy" class="w-full h-auto max-h-[500px] object-contain bg-gray-50 rounded-lg">
                    @endif
                    
                    @if(strtolower($listing->status) !== 'active')
                        <div class="absolute top-4 left-4 z-10">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                {{ $listing->status }}
                            </span>
                        </div>
                    @endif
                </div>

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
                            x-data="{}"
                            type="button"
                            x-on:click="$dispatch('open-contact-modal', {
                                listingId: {{ $listing->id }},
                                title: @js($listing->title),
                                price: @js((string) $listing->price),
                                phone: @js($listing->show_phone ? ($listing->phone_number ?? '') : ''),
                                whatsappPhone: @js($listing->whatsapp_contact ?? $listing->phone_number ?? ''),
                                contactEmail: @js($listing->show_email ? ($listing->contact_email ?? '') : ''),
                                sellerName: @js($listing->contact_name ?? $listing->user?->name ?? 'Seller'),
                                sellerId: {{ $listing->user_id }},
                                isAuth: @js(auth()->check())
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
                <div class="bg-white rounded-xl shadow-card border border-gray-100 p-6" x-data="{
                    isFollowing: {{ auth()->check() && auth()->user()->isFollowing($listing->user_id) ? 'true' : 'false' }},
                    followerCount: {{ $listing->user->follower_count ?? 0 }},
                    toggleFollow() {
                        @if(!auth()->check())
                            window.location.href = '{{ route('login') }}';
                            return;
                        @endif
                        
                        fetch('{{ route('follow.toggle', $listing->user_id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.isFollowing = data.is_following;
                                this.followerCount = data.follower_count;
                            } else if (data.error) {
                                alert(data.error);
                            }
                        })
                        .catch(err => console.error(err));
                    }
                }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">Seller Information</h3>
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full" x-text="followerCount + ' Followers'"></span>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-gray-100 text-primary flex items-center justify-center font-bold text-xl shrink-0">
                                {{ strtoupper(substr($listing->user?->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-dark text-base">{{ $listing->user?->name ?? 'Private Seller' }}</h4>
                                <p class="text-xs text-gray-500">Member since {{ $listing->user?->created_at->format('M Y') ?? 'Recently' }}</p>
                            </div>
                        </div>

                        @if(auth()->id() !== $listing->user_id)
                            <button @click="toggleFollow()" 
                                :class="isFollowing 
                                    ? 'bg-white border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-50' 
                                    : 'bg-gradient-to-r from-emerald-600 to-emerald-500 text-white hover:from-emerald-700 hover:to-emerald-600 border-2 border-transparent'"
                                class="sm:ml-auto w-full sm:w-auto px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition-all hover:scale-[1.02] hover:shadow-md flex items-center justify-center gap-1.5 shrink-0">
                                <template x-if="isFollowing">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Following
                                    </div>
                                </template>
                                <template x-if="!isFollowing">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        Follow
                                    </div>
                                </template>
                            </button>
                        @endif
                    </div>
                    
                    <a href="{{ route('sellers.show', $listing->user->slug) }}" class="block text-center text-sm font-semibold text-primary hover:underline bg-secondary py-2 rounded-md">
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

                <!-- Contact Details Card -->
                <div class="bg-white rounded-xl shadow-card border border-gray-100 p-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Contact Details</h3>

                    @auth
                        <ul class="space-y-3">

                            {{-- Phone --}}
                            @if($listing->show_phone && $listing->phone_number)
                                <li class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-400">Phone</p>
                                        <a href="tel:{{ $listing->phone_number }}"
                                           class="text-sm font-semibold text-primary hover:underline">
                                            {{ $listing->formatted_phone }}
                                        </a>
                                    </div>
                                </li>
                            @endif

                            {{-- WhatsApp --}}
                            @if($listing->phone_number)
                                <li class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-50">
                                        <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-xs text-gray-400">WhatsApp</p>
                                        @php
                                            $waNumber = preg_replace('/\D/', '', $listing->whatsapp_contact ?? $listing->phone_number);
                                            if (str_starts_with($waNumber, '0')) $waNumber = '94' . substr($waNumber, 1);
                                        @endphp
                                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer"
                                           class="text-sm font-semibold text-green-600 hover:underline">
                                            Chat on WhatsApp
                                        </a>
                                    </div>
                                </li>
                            @endif

                            {{-- Email --}}
                            @if($listing->show_email && $listing->contact_email)
                                <li class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0 overflow-hidden">
                                        <p class="text-xs text-gray-400">Email</p>
                                        <a href="mailto:{{ $listing->contact_email }}"
                                           class="truncate text-sm font-semibold text-blue-600 hover:underline">
                                            {{ $listing->contact_email }}
                                        </a>
                                    </div>
                                </li>
                            @endif

                            {{-- No contact info shown message --}}
                            @if(!($listing->show_phone && $listing->phone_number) && !($listing->show_email && $listing->contact_email))
                                <li class="text-xs text-gray-500">
                                    Use the <span class="font-semibold text-primary">Contact Seller</span> button above or send a direct message.
                                </li>
                            @endif

                        </ul>
                    @else
                        <div class="rounded-lg bg-slate-50 border border-slate-100 p-4 text-center">
                            <p class="text-xs text-slate-500 mb-3">
                                <span class="font-semibold">Sign in</span> to view the seller's contact details.
                            </p>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-primary px-4 py-2 text-xs font-bold text-white hover:bg-green-700 transition-colors">
                                Log in to view
                            </a>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
    
    <!-- More From This Seller Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900">More from {{ $listing->user->name }}</h2>
            <a href="{{ route('sellers.show', $listing->user->slug) }}" class="text-emerald-700 font-semibold hover:underline flex items-center gap-1">
                View all advertisements <span aria-hidden="true">&rarr;</span>
            </a>
        </div>

        @if(isset($otherListings) && $otherListings->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($otherListings as $other)
                    <x-listing-card :listing="$other" />
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-100 p-8 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <h3 class="text-lg font-bold text-slate-900 mb-1">No other active advertisements</h3>
                <p class="text-gray-500 text-sm mb-4">This seller currently doesn't have any other items for sale.</p>
                <a href="{{ route('listings.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition-colors">
                    Browse other categories
                </a>
            </div>
        @endif
    </div>
    
    <!-- Contact Modal Component -->
    <x-contact-modal />
</x-app-layout>

<x-app-layout :title="$seller->name . ' - Seller Profile'">
    <div class="bg-slate-50 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Profile Header Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8" x-data="{
                isFollowing: {{ auth()->check() && auth()->user()->isFollowing($seller->id) ? 'true' : 'false' }},
                followerCount: {{ $seller->followers_count ?? 0 }},
                toggleFollow() {
                    @if(!auth()->check())
                        window.location.href = '{{ route('login') }}';
                        return;
                    @endif
                    
                    fetch('{{ route('follow.toggle', $seller->id) }}', {
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
                <div class="h-32 bg-emerald-700 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="px-6 sm:px-10 pb-8 relative">
                    <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-end -mt-12 mb-6">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-white p-1.5 shrink-0 shadow-md">
                            <div class="w-full h-full rounded-full bg-slate-100 text-emerald-700 flex items-center justify-center font-bold text-4xl border border-slate-200">
                                {{ strtoupper(substr($seller->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0 pb-2">
                            <h1 class="text-3xl font-extrabold text-slate-900 flex items-center gap-2">
                                {{ $seller->name }}
                                @if($seller->is_verified_seller)
                                    <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @endif
                            </h1>
                            <p class="text-slate-500 mt-1 flex items-center gap-4">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Member since {{ $seller->created_at->format('F Y') }}
                                </span>
                                @if($seller->location_city)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0ZM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                        {{ $seller->location_city }}
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-3 w-full sm:w-auto pb-2 shrink-0">
                            @if(auth()->id() !== $seller->id)
                                <button @click="toggleFollow()" 
                                    :class="isFollowing 
                                        ? 'bg-white border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-50' 
                                        : 'bg-gradient-to-r from-emerald-600 to-emerald-500 text-white hover:from-emerald-700 hover:to-emerald-600 border-2 border-transparent'"
                                    class="flex-1 sm:flex-none px-6 py-2.5 rounded-lg font-bold shadow-sm transition-all hover:scale-[1.02] hover:shadow-md flex items-center justify-center gap-1.5 shrink-0">
                                    <template x-if="isFollowing">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Following
                                        </div>
                                    </template>
                                    <template x-if="!isFollowing">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                            Follow
                                        </div>
                                    </template>
                                </button>
                                <button class="flex-1 sm:flex-none px-6 py-2.5 rounded-lg font-bold bg-[#F59E0B] text-[#1E3A29] hover:bg-amber-500 transition-colors shadow-sm focus:ring-2 focus:ring-amber-500 focus:ring-offset-2" @click="window.dispatchEvent(new CustomEvent('open-contact-modal', { detail: { sellerId: {{ $seller->id }} } }))">
                                    Contact
                                </button>
                            @else
                                <a href="{{ route('profile.edit') }}" class="px-6 py-2.5 rounded-lg font-bold bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                    Edit Profile
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-slate-100">
                        <div class="col-span-1 md:col-span-2 text-slate-700 leading-relaxed text-sm">
                            <h3 class="font-bold text-slate-900 mb-2">About the Seller</h3>
                            @if($seller->bio)
                                <p>{{ $seller->bio }}</p>
                            @else
                                <p class="text-slate-400 italic">This seller hasn't provided a bio yet.</p>
                            @endif
                        </div>
                        <div class="col-span-1 flex items-center justify-around md:justify-end gap-8">
                            <div class="text-center">
                                <span class="block text-2xl font-extrabold text-slate-900">{{ $listings->total() }}</span>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Active Ads</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-2xl font-extrabold text-slate-900" x-text="followerCount"></span>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Followers</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-2xl font-extrabold text-slate-900 flex items-center justify-center gap-1">
                                    4.8 <svg class="w-4 h-4 text-amber-500 -mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </span>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Rating</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Listings Grid --}}
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-900">Advertisements from {{ $seller->name }}</h2>
            </div>
            
            @if($listings->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($listings as $listing)
                        <x-listing-card :listing="$listing" />
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $listings->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">No active advertisements</h3>
                    <p class="text-slate-500 mb-0">This seller currently doesn't have any items for sale.</p>
                </div>
            @endif

        </div>
    </div>
    
    <x-contact-modal />
</x-app-layout>

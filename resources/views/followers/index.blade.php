<x-app-layout title="My Followed Sellers">
    <div class="bg-slate-50 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">My Followed Sellers</h1>
                    <p class="text-sm text-slate-500 mt-1">You are following {{ $followings->total() }} sellers</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-100 flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if($followings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($followings as $seller)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 transition-all duration-200 hover:-translate-y-1 hover:shadow-md flex flex-col h-full group">
                            
                            <div class="flex items-start gap-4 mb-5">
                                <div class="relative shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 text-emerald-700 flex items-center justify-center font-bold text-2xl border-2 border-white shadow-sm">
                                        {{ strtoupper(substr($seller->name, 0, 1)) }}
                                    </div>
                                    <!-- Online dot -->
                                    <span class="absolute bottom-0.5 right-0.5 block w-3.5 h-3.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-lg text-slate-900 truncate flex items-center gap-1.5">
                                        {{ $seller->name }}
                                        @if($seller->is_verified_seller)
                                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                    </h3>
                                    <p class="text-sm text-slate-500 truncate flex items-center gap-1 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0ZM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                        {{ $seller->location_city ?? 'Sri Lanka' }}
                                    </p>
                                    
                                    <div class="flex items-center gap-3 mt-2">
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 bg-slate-100 px-2 py-1 rounded-md">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            {{ $seller->followers_count ?? 0 }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-md">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            4.8
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-slate-100 flex gap-3">
                                <a href="{{ route('sellers.show', $seller->slug) }}" class="flex-1 inline-flex justify-center items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition-colors shadow-sm focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                                    View Profile
                                </a>
                                
                                <form action="{{ route('follow.destroy', $seller->id) }}" method="POST" class="shrink-0" onsubmit="return confirm('Are you sure you want to unfollow this seller?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex justify-center items-center border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 text-sm font-bold py-2 px-3 rounded-lg transition-colors focus:ring-2 focus:ring-red-500 focus:ring-offset-1" title="Unfollow">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/></svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $followings->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm max-w-3xl mx-auto mt-10">
                    <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">You haven't followed any sellers yet</h2>
                    <p class="text-slate-500 mb-8 max-w-md mx-auto">Follow your favorite sellers to keep up with their latest items and never miss a great deal again.</p>
                    <a href="{{ route('listings.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-500 px-8 py-3.5 text-base font-bold text-white shadow-sm transition-all hover:scale-[1.02] hover:shadow-md hover:from-emerald-700 hover:to-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Explore Listings
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

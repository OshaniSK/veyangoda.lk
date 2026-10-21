{{--
    Partial: home-listings.blade.php
    Rendered server-side and returned as JSON { html } for AJAX requests
    from the home page (welcome.blade.php).
--}}
<div class="mb-6">
    <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">
        @if(!empty($requiresLoginForFollows))
            Followed Members
        @elseif(!empty($isFilteringFollowed))
            Ads from Followed Sellers
        @elseif(request('sub_category'))
            Ads in {{ ucwords(str_replace('-', ' ', request('sub_category'))) }}
        @elseif(request('category'))
            Ads in {{ $categories->firstWhere('slug', request('category'))?->name ?? ucwords(str_replace('-', ' ', request('category'))) }}
        @elseif(request('search'))
            Search results for "{{ request('search') }}"
        @else
            Ads in Sri Lanka
        @endif
    </h2>
    <p class="text-sm text-slate-500 mt-1">
        @if(!empty($requiresLoginForFollows))
            Authentication required to view members you follow
        @else
            Showing {{ $listings->firstItem() ?? 0 }}-{{ $listings->lastItem() ?? 0 }} of {{ number_format($listings->total()) }} ads
        @endif
    </p>
</div>

@if(!empty($requiresLoginForFollows))
    {{-- Guest prompt when 'Only members' is selected --}}
    <div class="rounded-2xl border border-amber-200 bg-amber-50/80 p-8 sm:p-10 text-center shadow-sm">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-amber-700">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900">Please log in to filter by followed sellers</h3>
        <p class="mx-auto mt-2 max-w-md text-sm text-slate-600 leading-relaxed">
            You need to be logged into your Veyangoda.lk account to view advertisements posted exclusively by sellers you follow.
        </p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#008060] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#006e52]">
                Log In
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Create Account
            </a>
        </div>
    </div>
@elseif(!empty($isFilteringFollowed) && $listings->isEmpty())
    {{-- Logged in user with no followed sellers or no ads from them --}}
    <div class="flex flex-col items-center justify-center rounded-2xl border border-slate-100 bg-white px-4 py-16 text-center shadow-sm">
        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-900">No ads from followed sellers</h3>
        <p class="mt-2 max-w-md text-sm text-slate-500 leading-relaxed">
            You haven't followed any sellers yet, or the sellers you follow haven't posted any active ads. Visit seller profiles and click "Follow" to see their updates here!
        </p>
        <button type="button" @click="resetToAllAds()" class="mt-6 font-semibold text-[#008060] hover:underline">
            Show all ads
        </button>
    </div>
@elseif($listings->count() > 0)
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
        <button type="button" @click="resetFilters()" class="mt-6 font-semibold text-[#008060] hover:underline">Clear all filters</button>
    </div>
@endif

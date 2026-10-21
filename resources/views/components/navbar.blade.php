<nav
    x-data="{ mobileMenuOpen: false, accountOpen: false, locationOpen: false }"
    class="sticky top-0 z-50 w-full bg-[#1E3A29] text-white shadow-md"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between lg:h-20">
            <a href="{{ route('home') }}" class="shrink-0 rounded-sm font-bold text-white transition-opacity hover:opacity-80 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white">
                <span class="text-lg sm:text-2xl">Veyangoda.lk</span>
            </a>

            <div class="hidden items-center gap-4 lg:flex">
                @unless(request()->routeIs('my-listings.*'))
                    <div x-data="{ open: false, activeDistrict: null }" @click.outside="open = false" @keydown.escape.window="open = false" class="relative">
                        <button
                            type="button"
                            @click="open = !open"
                            :aria-expanded="open.toString()"
                            class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                        >
                            <svg aria-hidden="true" class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0ZM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <span>{{ request('location') ?: 'All of Sri Lanka' }}</span>
                            <svg aria-hidden="true" class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                        </button>
                        <div x-cloak x-show="open" class="absolute right-0 z-50 mt-2 w-[540px] md:w-[600px] overflow-hidden rounded-xl border border-slate-200 bg-white text-slate-800 shadow-2xl ring-1 ring-black/5">
                            @php
                                $navbarLocations = \App\Models\Location::getHierarchy();
                            @endphp
                            <!-- Navbar Location Header -->
                            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-2.5 bg-slate-50/70">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Choose District & Area</span>
                                <a href="{{ route('listings.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                    All of Sri Lanka
                                </a>
                            </div>
                            <!-- Two Column Master-Detail -->
                            <div class="grid grid-cols-2 divide-x divide-slate-200">
                                <!-- Districts (A-Z) -->
                                <div class="max-h-[320px] overflow-y-auto space-y-0.5 p-2 custom-scrollbar bg-slate-50/40">
                                    <div class="px-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-500">Districts (A-Z)</div>
                                    @foreach($navbarLocations as $dist => $areas)
                                        <button
                                            type="button"
                                            @mouseenter="activeDistrict = '{{ $dist }}'"
                                            @click="activeDistrict = '{{ $dist }}'"
                                            :class="activeDistrict === '{{ $dist }}' ? 'bg-emerald-600 text-white font-semibold' : 'text-slate-700 hover:bg-slate-100 font-medium'"
                                            class="group flex w-full items-center justify-between rounded-lg px-3 py-1.5 text-left text-sm transition"
                                        >
                                            <span>{{ $dist }}</span>
                                            <span class="text-xs transition-transform" :class="activeDistrict === '{{ $dist }}' ? 'text-white' : 'text-slate-400 group-hover:text-slate-600'">▶</span>
                                        </button>
                                    @endforeach
                                </div>
                                <!-- Local Areas -->
                                <div class="bg-white">
                                    <div x-show="!activeDistrict" class="flex h-[320px] flex-col items-center justify-center p-4 text-center text-slate-400">
                                        <p class="text-xs text-slate-500">Hover or click a district to view its local areas</p>
                                    </div>
                                    @foreach($navbarLocations as $dist => $areas)
                                        <div x-show="activeDistrict === '{{ $dist }}'" x-cloak class="flex flex-col h-full">
                                            <div class="px-3 pt-2 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-500 truncate">
                                                Areas in {{ $dist }}
                                            </div>
                                            <div class="max-h-[280px] overflow-y-auto space-y-0.5 p-2 custom-scrollbar flex-1">
                                                <a
                                                    href="{{ route('listings.index', ['location' => $dist]) }}"
                                                    class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-bold text-emerald-700 hover:bg-emerald-50 bg-emerald-50/50 mb-1"
                                                >
                                                    All of {{ $dist }}
                                                </a>
                                                @foreach($areas as $area)
                                                    <a
                                                        href="{{ route('listings.index', ['location' => $area]) }}"
                                                        class="block rounded-lg px-3 py-1 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900"
                                                    >
                                                        {{ $area }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('contact.index') }}" class="rounded-sm px-2 py-2 text-sm font-medium text-white transition-opacity hover:opacity-75 hover:underline hover:underline-offset-4 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        Contact Us
                    </a>
                @endunless

                <div x-data="{ open: false }" class="relative">
                    <button
                        type="button"
                        @click="open = !open"
                        @keydown.escape.window="open = false"
                        :aria-expanded="open.toString()"
                        class="inline-flex items-center gap-2 rounded-lg px-2 py-2 text-sm font-medium text-white transition-opacity hover:opacity-75 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    >
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-xs font-bold text-white ring-1 ring-white/25">
                            @auth{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}@else
                                <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z"/></svg>
                            @endauth
                        </span>
                        <span>{{ auth()->check() ? auth()->user()->name : 'My Account' }}</span>
                        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>

                    <div x-cloak x-show="open" @click.outside="open = false" class="absolute right-0 z-50 mt-2 w-52 overflow-hidden rounded-lg border border-slate-200 bg-white py-1 text-slate-800 shadow-xl">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">Dashboard</a>
                            <a href="{{ route('my-listings.index') }}" class="block px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">My Listings</a>
                            <a href="{{ route('followers.index') }}" class="flex items-center justify-between px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">
                                <span>My Followed Sellers</span>
                                @php($followerCount = auth()->user()->follower_count ?? 0)
                                @if($followerCount > 0)
                                    <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-900">{{ $followerCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('messages.inbox') }}" class="flex items-center justify-between px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">
                                <span>Messages</span>
                                @php($unreadMessages = auth()->user()->unreadMessageCount())
                                @if($unreadMessages > 0)
                                    <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-900">{{ $unreadMessages }}</span>
                                @endif
                            </a>
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">Admin Panel</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2.5 text-left text-sm transition-colors hover:bg-emerald-50">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">Sign in</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">Create an account</a>
                        @endauth
                    </div>
                </div>

                @if(request()->routeIs('my-listings.*'))
                    <span class="sr-only">Ad posting is available from the account page.</span>
                @elseif(request()->routeIs('listings.create'))
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#F59E0B] px-4 py-2.5 text-sm font-bold text-[#1E3A29] shadow-sm transition hover:bg-amber-400 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#1E3A29]">
                        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19 3 12l7-7M3 12h18"/></svg>
                        Back to Home
                    </a>
                @else
                    <a href="{{ route('listings.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#F59E0B] px-5 py-2.5 text-sm font-extrabold text-[#1E3A29] shadow-sm transition hover:bg-amber-400 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#1E3A29]">
                        POST YOUR AD
                    </a>
                @endif
            </div>

            <button
                type="button"
                @click="mobileMenuOpen = !mobileMenuOpen"
                @keydown.escape.window="mobileMenuOpen = false"
                :aria-expanded="mobileMenuOpen.toString()"
                aria-label="Toggle navigation menu"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-white transition-colors hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white lg:hidden"
            >
                <svg x-show="!mobileMenuOpen" aria-hidden="true" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-cloak x-show="mobileMenuOpen" aria-hidden="true" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </div>

    <div x-cloak x-show="mobileMenuOpen" @click.outside="mobileMenuOpen = false" class="border-t border-white/15 bg-[#1E3A29] px-4 pb-5 pt-3 lg:hidden">
        <div class="mx-auto max-w-7xl space-y-1">
            @unless(request()->routeIs('my-listings.*'))
                <div class="border-b border-white/15 pb-3">
                    <button type="button" @click="locationOpen = !locationOpen" :aria-expanded="locationOpen.toString()" class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-left text-sm font-semibold text-white transition-colors hover:bg-white/10">
                        <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0ZM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        <span class="flex-1">All of Sri Lanka</span>
                        <svg aria-hidden="true" class="h-4 w-4 transition-transform" :class="locationOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <div x-cloak x-show="locationOpen" class="ml-4 space-y-1 py-1 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                        <a href="{{ route('listings.index') }}" class="block rounded-lg px-3 py-2 text-sm font-bold text-white transition-colors hover:bg-white/10">All of Sri Lanka</a>
                        @foreach(\App\Models\Location::getHierarchy() as $dist => $areas)
                            <div x-data="{ distOpen: false }" class="border-t border-white/10 pt-1">
                                <button type="button" @click="distOpen = !distOpen" class="flex w-full items-center justify-between rounded-lg px-3 py-1.5 text-sm font-semibold text-white/90 hover:bg-white/10">
                                    <span>{{ $dist }}</span>
                                    <span class="text-xs transition-transform" :class="distOpen ? 'rotate-90' : ''">▶</span>
                                </button>
                                <div x-show="distOpen" class="ml-4 space-y-0.5 py-1">
                                    <a href="{{ route('listings.index', ['location' => $dist]) }}" class="block rounded px-2.5 py-1 text-xs font-bold text-emerald-300 hover:bg-white/10">
                                        All of {{ $dist }}
                                    </a>
                                    @foreach($areas as $area)
                                        <a href="{{ route('listings.index', ['location' => $area]) }}" class="block rounded px-2.5 py-1 text-xs text-white/80 hover:bg-white/10">
                                            {{ $area }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('contact.index') }}" class="block rounded-lg px-3 py-3 text-sm font-semibold text-white transition-colors hover:bg-white/10 hover:underline hover:underline-offset-4">Contact Us</a>
            @endunless

            <div class="border-t border-white/15 pt-2">
                <button type="button" @click="accountOpen = !accountOpen" :aria-expanded="accountOpen.toString()" class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-left text-sm font-semibold text-white transition-colors hover:bg-white/10">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-xs font-bold ring-1 ring-white/25">
                        @auth{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}@else
                            <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z"/></svg>
                        @endauth
                    </span>
                    <span class="flex-1">{{ auth()->check() ? auth()->user()->name : 'My Account' }}</span>
                    <svg aria-hidden="true" class="h-4 w-4 transition-transform" :class="accountOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                </button>
                <div x-cloak x-show="accountOpen" class="ml-11 space-y-1 pb-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">Dashboard</a>
                        <a href="{{ route('my-listings.index') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">My Listings</a>
                        <a href="{{ route('followers.index') }}" class="flex items-center justify-between rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">
                            <span>My Followed Sellers</span>
                            @php($followerCount = auth()->user()->follower_count ?? 0)
                            @if($followerCount > 0)
                                <span class="rounded-full bg-white/20 px-2 py-0.5 text-xs font-bold">{{ $followerCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('messages.inbox') }}" class="flex items-center justify-between rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">
                            <span>Messages</span>
                            @php($unreadMessages = auth()->user()->unreadMessageCount())
                            @if($unreadMessages > 0)
                                <span class="rounded-full bg-white/20 px-2 py-0.5 text-xs font-bold">{{ $unreadMessages }}</span>
                            @endif
                        </a>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm text-white/90 transition-colors hover:bg-white/10">Log Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">Sign in</a>
                        <a href="{{ route('register') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">Create an account</a>
                    @endauth
                </div>
            </div>

            @if(request()->routeIs('my-listings.*'))
                <span class="sr-only">Ad posting is available from the account page.</span>
            @elseif(request()->routeIs('listings.create'))
                <a href="{{ route('home') }}" class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#F59E0B] px-5 py-3 text-sm font-bold text-[#1E3A29] transition hover:bg-amber-400">
                    <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19 3 12l7-7M3 12h18"/></svg>
                    Back to Home
                </a>
            @else
                <a href="{{ route('listings.create') }}" class="mt-3 inline-flex w-full items-center justify-center rounded-lg bg-[#F59E0B] px-5 py-3 text-sm font-extrabold text-[#1E3A29] transition hover:bg-amber-400">
                    POST YOUR AD
                </a>
            @endif
        </div>
    </div>
</nav>
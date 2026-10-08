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
                    <div x-data="{ open: false }" class="relative">
                        <button
                            type="button"
                            @click="open = !open"
                            @keydown.escape.window="open = false"
                            :aria-expanded="open.toString()"
                            class="inline-flex items-center gap-2 rounded-lg border border-white/25 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white"
                        >
                            <svg aria-hidden="true" class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0ZM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <span>All of Sri Lanka</span>
                            <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                        </button>
                        <div x-cloak x-show="open" @click.outside="open = false" class="absolute right-0 z-50 mt-2 w-52 overflow-hidden rounded-lg border border-slate-200 bg-white py-1 text-slate-800 shadow-xl">
                            <a href="{{ route('listings.index') }}" class="block px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">All of Sri Lanka</a>
                            @foreach(['Veyangoda', 'Colombo', 'Gampaha', 'Kandy', 'Kurunegala', 'Matale'] as $place)
                                <a href="{{ route('listings.index', ['location' => $place]) }}" class="block px-4 py-2.5 text-sm transition-colors hover:bg-emerald-50">{{ $place }}</a>
                            @endforeach
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
                    <div x-cloak x-show="locationOpen" class="ml-8 space-y-1 py-1">
                        <a href="{{ route('listings.index') }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">All of Sri Lanka</a>
                        @foreach(['Veyangoda', 'Colombo', 'Gampaha', 'Kandy', 'Kurunegala', 'Matale'] as $place)
                            <a href="{{ route('listings.index', ['location' => $place]) }}" class="block rounded-lg px-3 py-2 text-sm text-white/90 transition-colors hover:bg-white/10">{{ $place }}</a>
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
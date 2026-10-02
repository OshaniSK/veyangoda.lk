<nav x-data="{ mobileMenuOpen: false }" class="bg-dark-green text-white shadow-md sticky top-0 z-50 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            
            <!-- Left: Logo & Location -->
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-10 h-10 bg-white text-dark-green rounded-full flex items-center justify-center font-bold text-xl">
                        V
                    </div>
                    <span class="text-base font-bold tracking-tight sm:text-2xl">Veyangoda.lk</span>
                </a>

                <!-- Location Dropdown (Desktop Only) -->
                <div x-data="{ open: false }" class="relative hidden lg:block">
                    <button type="button" @click="open = !open" @keydown.escape.window="open = false" class="flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium transition-colors hover:bg-white/10 focus:outline-none">
                        <svg aria-hidden="true" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>All of Sri Lanka</span>
                        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <div x-cloak x-show="open" @click.outside="open = false" class="absolute left-0 z-50 mt-2 w-52 rounded-lg border border-slate-100 bg-white py-1 text-slate-800 shadow-xl">
                        <a href="{{ route('listings.index') }}" class="block px-4 py-2.5 text-sm hover:bg-emerald-50">All of Sri Lanka</a>
                        @foreach(['Veyangoda', 'Colombo', 'Gampaha', 'Kandy', 'Kurunegala', 'Matale'] as $place)
                            <a href="{{ route('listings.index', ['location' => $place]) }}" class="block px-4 py-2.5 text-sm hover:bg-emerald-50">{{ $place }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Center: Text Links -->
            <div class="hidden lg:flex flex-1 justify-center">
                <a href="{{ route('contact.index') }}"
                   class="font-medium hover:text-gray-200 transition-colors {{ request()->routeIs('contact.*') ? 'text-white underline underline-offset-4' : '' }}">
                    Contact Us
                </a>
            </div>

            <!-- Right: Links & Post Ad -->
            <div class="hidden lg:flex items-center gap-6">
                @guest
                    <div x-data="{ open: false }" class="relative">
                        <button type="button" @click="open = !open" @keydown.escape.window="open = false" class="flex items-center gap-2 font-medium transition-colors hover:text-emerald-100 focus:outline-none">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/15">
                                <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <span>My Account</span>
                            <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                        </button>
                        <div x-cloak x-show="open" @click.outside="open = false" class="absolute right-0 z-50 mt-3 w-48 rounded-lg border border-slate-100 bg-white py-1 text-slate-800 shadow-xl">
                            <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm hover:bg-emerald-50">Sign in</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2.5 text-sm hover:bg-emerald-50">Create an account</a>
                        </div>
                    </div>
                @else
                    <!-- My Account Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 font-medium hover:text-gray-200 transition-colors focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <span>My Account</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white text-dark rounded-md shadow-lg py-1 z-50" style="display: none;">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('my-listings.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">My Ads</a>
                            <a href="{{ route('messages.inbox') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Messages</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @endguest

                @if(request()->routeIs('listings.create'))
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-md bg-accent-yellow px-5 py-2.5 font-bold text-dark-green shadow-md transition hover:scale-[1.02] hover:bg-yellow-400">
                        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19 3 12l7-7M3 12h18"/></svg>
                        Back to Home
                    </a>
                @else
                    <a href="{{ route('listings.create') }}" class="bg-accent-yellow text-dark-green hover:bg-yellow-500 font-bold py-2 px-6 rounded-md shadow-md transition-transform hover:scale-105 flex items-center gap-2">
                        POST YOUR AD
                    </a>
                @endif
            </div>

            <!-- Mobile: Right Side (Hamburger, Post Ad) -->
            <div class="flex lg:hidden items-center gap-3">
                @if(request()->routeIs('listings.create'))
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 rounded-md bg-accent-yellow px-3 py-2 text-xs font-bold text-dark-green shadow-md hover:bg-yellow-400 sm:text-sm">
                        <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19 3 12l7-7M3 12h18"/></svg>
                        Back to Home
                    </a>
                @else
                    <a href="{{ route('listings.create') }}" class="bg-accent-yellow text-dark-green hover:bg-yellow-500 font-bold py-1.5 px-4 rounded-md text-sm shadow-md flex items-center gap-1">
                        Post Ad
                    </a>
                @endif

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white p-2 focus:outline-none">
                    <svg class="w-6 h-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg class="w-6 h-6" x-show="mobileMenuOpen" style="display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" style="display:none;" class="lg:hidden bg-dark-green border-t border-green-800">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('contact.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-800 {{ request()->routeIs('contact.*') ? 'bg-green-800' : '' }}">Contact Us</a>
            @guest
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-800">Login / Register</a>
            @else
                <div class="px-3 py-2 border-b border-green-800 mb-2">
                    <div class="font-medium text-lg">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-green-200">{{ Auth::user()->email }}</div>
                </div>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-800">Dashboard</a>
                <a href="{{ route('my-listings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-800">My Ads</a>
                <a href="{{ route('messages.inbox') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-800">Messages</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium hover:bg-green-800">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

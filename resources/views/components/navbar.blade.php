<nav x-data="{ mobileMenuOpen: false }" class="bg-primary text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            
            <!-- Left: Logo & Location -->
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2">
                    <!-- Icon/Logo -->
                    <div class="w-10 h-10 bg-white text-primary rounded-full flex items-center justify-center font-bold text-xl">
                        V
                    </div>
                    <span class="font-bold text-2xl tracking-tight hidden sm:block">Veyangoda.lk</span>
                </a>

                <!-- Location Dropdown (Desktop Only) -->
                <div class="hidden lg:flex items-center gap-1 hover:bg-white/10 px-3 py-2 rounded-md cursor-pointer transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="font-medium text-sm">All of Sri Lanka</span>
                </div>
            </div>

            <!-- Center: Search Bar (Desktop Only) -->
            <div class="hidden lg:flex flex-1 max-w-2xl mx-8">
                <form action="{{ route('listings.index') }}" method="GET" class="w-full relative">
                    <input type="text" name="search" placeholder="What are you looking for?" class="w-full h-12 pl-4 pr-12 rounded-full text-dark focus:outline-none focus:ring-2 focus:ring-yellow-400 border-none shadow-inner">
                    <button type="submit" class="absolute right-1 top-1 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center hover:bg-green-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>

            <!-- Right: Links & Post Ad -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('contact.index') }}"
                   class="font-medium hover:text-gray-200 transition-colors {{ request()->routeIs('contact.*') ? 'text-white underline underline-offset-4' : '' }}">
                    Contact Us
                </a>

                @guest
                    <a href="{{ route('login') }}" class="font-medium hover:text-gray-200 transition-colors flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Login
                    </a>
                @else
                    <!-- My Account Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 font-medium hover:text-gray-200 transition-colors focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
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

                <!-- High Contrast Post Ad Button -->
                <a href="{{ route('listings.create') }}" class="bg-yellow-400 text-yellow-900 hover:bg-yellow-500 font-bold py-2 px-6 rounded-full shadow-md transition-transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    POST YOUR AD
                </a>
            </div>

            <!-- Mobile: Right Side (Search Toggle, Hamburger, Post Ad) -->
            <div class="flex lg:hidden items-center gap-3">
                <!-- Mobile Post Ad (Smaller) -->
                <a href="{{ route('listings.create') }}" class="bg-yellow-400 text-yellow-900 hover:bg-yellow-500 font-bold py-1.5 px-4 rounded-full text-sm shadow-md flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Post Ad
                </a>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white p-2 focus:outline-none">
                    <svg class="w-6 h-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg class="w-6 h-6" x-show="mobileMenuOpen" style="display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Search Bar (Always visible below header on mobile) -->
        <div class="lg:hidden pb-4">
            <form action="{{ route('listings.index') }}" method="GET" class="w-full relative">
                <input type="text" name="search" placeholder="What are you looking for?" class="w-full h-12 pl-4 pr-12 rounded-full text-dark focus:outline-none focus:ring-2 focus:ring-yellow-400 border-none shadow-inner">
                <button type="submit" class="absolute right-1 top-1 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" style="display:none;" class="lg:hidden bg-primary border-t border-green-700">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('contact.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-700 {{ request()->routeIs('contact.*') ? 'bg-green-700' : '' }}">Contact Us</a>
            @guest
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-700">Login / Register</a>
            @else
                <div class="px-3 py-2 border-b border-green-700 mb-2">
                    <div class="font-medium text-lg">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-green-200">{{ Auth::user()->email }}</div>
                </div>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-700">Dashboard</a>
                <a href="{{ route('my-listings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-700">My Ads</a>
                <a href="{{ route('messages.inbox') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-green-700">Messages</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium hover:bg-green-700">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

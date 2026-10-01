{{-- ═══════════════════════════════════════════════════════════════
     DASHBOARD NAVIGATION — Gradient Header
     Background: violet(#6C2BD9) → blue(#2563EB) → teal(#06B6D4)
     WCAG AA: all text is white or white/80 on the dark gradient
═══════════════════════════════════════════════════════════════ --}}
<nav x-data="{ open: false }"
     class="header-gradient border-grad sticky top-0 z-50">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2 group">
                        {{-- White icon box with subtle white ring --}}
                        <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm
                                    flex items-center justify-center
                                    ring-1 ring-white/30
                                    group-hover:bg-white/30 transition-colors">
                            <x-application-logo class="block h-5 w-auto fill-current text-white" />
                        </div>
                        <span class="text-white font-bold text-lg tracking-tight hidden sm:inline">
                            {{ config('app.name', 'CraftNest') }}
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="!text-white/80 hover:!text-white hover:!bg-white/10 !border-transparent
                               data-[active=true]:!text-white data-[active=true]:!border-white/60 rounded-lg px-3">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('my-listings.index')" :active="request()->routeIs('my-listings.index')"
                        class="!text-white/80 hover:!text-white hover:!bg-white/10 !border-transparent
                               data-[active=true]:!text-white data-[active=true]:!border-white/60 rounded-lg px-3">
                        {{ __('My Listings') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side (Notifications + Settings/Hamburger) -->
            <div class="flex items-center gap-3 sm:gap-6">
                
                @auth
                    <x-notification-bell />
                @endauth

                <!-- Settings Dropdown (Desktop) -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-lg
                                           text-sm font-medium text-white/90
                                           bg-white/10 hover:bg-white/20
                                           border border-white/20 hover:border-white/40
                                           transition-all duration-150 focus:outline-none">
                                {{-- User initial avatar --}}
                                <span class="w-6 h-6 rounded-full bg-white/30 text-white text-xs font-bold
                                             flex items-center justify-center uppercase">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-4 w-4 text-white/60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('my-listings.index')">
                                {{ __('My Listings') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('messages.inbox')" class="flex justify-between items-center">
                                {{ __('Messages') }}
                                @php $navUnread = Auth::user()->unreadMessageCount(); @endphp
                                @if($navUnread > 0)
                                    <span class="bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $navUnread }}</span>
                                @endif
                            </x-dropdown-link>

                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    {{ __('Admin Panel') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Log Out -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile Hamburger -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-lg
                                   text-white/70 hover:text-white hover:bg-white/10
                                   focus:outline-none focus:bg-white/10 transition duration-150">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Mobile Responsive Panel -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/10 backdrop-blur-md border-t border-white/20">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="!text-white/90 hover:!text-white hover:!bg-white/10 !border-transparent rounded-lg">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('my-listings.index')" :active="request()->routeIs('my-listings.index')"
                class="!text-white/90 hover:!text-white hover:!bg-white/10 !border-transparent rounded-lg">
                {{ __('My Listings') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive User Options -->
        <div class="pt-4 pb-3 border-t border-white/20 px-3">
            <div class="flex items-center gap-3 px-1 mb-3">
                <div class="w-9 h-9 rounded-full bg-white/25 text-white font-bold
                            flex items-center justify-center text-sm uppercase">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-sm text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-white/60">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('my-listings.index')"
                    class="!text-white/90 hover:!text-white hover:!bg-white/10 rounded-lg">
                    {{ __('My Listings') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('messages.inbox')"
                    class="!text-white/90 hover:!text-white hover:!bg-white/10 rounded-lg flex justify-between items-center pr-6">
                    {{ __('Messages') }}
                    @if($navUnread > 0)
                        <span class="bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $navUnread }}</span>
                    @endif
                </x-responsive-nav-link>

                @if(Auth::user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.dashboard')"
                        class="!text-white/90 hover:!text-white hover:!bg-white/10 rounded-lg">
                        {{ __('Admin Panel') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('profile.edit')"
                    class="!text-white/90 hover:!text-white hover:!bg-white/10 rounded-lg">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="!text-white/90 hover:!text-white hover:!bg-white/10 rounded-lg">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


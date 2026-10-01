<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-stone-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Homemade Marketplace - Authentic Small Business & Domestic Goods' }}</title>
    <meta name="description" content="Discover handmade domestic crafts, artisan foods, home decor, and textiles made by local makers.">

    {{-- Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    {{-- Tailwind CSS: Vite Asset Bundling with CDN Fallback --}}
    @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Alpine.js --}}
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            amber: {
                                50: '#fffbeb',
                                100: '#fef3c7',
                                200: '#fde68a',
                                300: '#fcd34d',
                                400: '#fbbf24',
                                500: '#f59e0b',
                                600: '#d97706',
                                700: '#b45309',
                                800: '#92400e',
                                900: '#78350f',
                                950: '#451a03',
                            }
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-full flex flex-col text-stone-800 bg-stone-50/50 selection:bg-amber-500 selection:text-white">
    {{-- Top Announcement Bar --}}
    <div class="bg-amber-950 text-amber-100 text-xs py-2 px-4 text-center font-medium border-b border-amber-900/60">
        <span class="inline-flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            Empowering 500+ local home-based creators and domestic artisans. Direct contact with 0% middleman fees.
        </span>
    </div>

    {{-- Primary Header / Navigation --}}
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-stone-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between gap-4">
            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0 group">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-amber-600 to-amber-800 flex items-center justify-center text-white shadow-md shadow-amber-900/10 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight text-stone-900 leading-none">Craft<span class="text-amber-700">Nest</span></span>
                    <span class="text-[10px] font-semibold text-stone-400 tracking-wider uppercase mt-0.5">Domestic Artisans</span>
                </div>
            </a>

            {{-- Right Nav Actions --}}
            <div class="flex items-center gap-3 sm:gap-4">
                @auth
                    <div class="flex items-center gap-3">
                        <a href="{{ Route::has('listings.my-ads') ? route('listings.my-ads') : url('/#') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900 hidden sm:inline-block">
                            My Ads
                        </a>
                        <div class="flex items-center gap-2 text-sm font-semibold text-stone-800">
                            <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                @else
                    <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="text-sm font-semibold text-stone-600 hover:text-amber-700 transition-colors px-2 py-1.5">
                        Log In
                    </a>
                @endauth

                {{-- Hero CTA: Post Ad (Selling Flow) --}}
                <a 
                    href="{{ route('listings.create') }}" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm shadow-md hover:shadow-lg hover:shadow-amber-700/20 transition-all active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Post Free Ad</span>
                </a>
            </div>
        </div>
    </header>

    {{-- Main View Body --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Universal Alpine Contact / Auth Modal --}}
    <x-contact-modal />

    {{-- Footer --}}
    <footer class="bg-stone-900 text-stone-300 pt-12 pb-8 border-t border-stone-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-stone-800 text-sm">
                <div class="space-y-3">
                    <span class="text-lg font-bold text-amber-50">Craft<span class="text-amber-500">Nest</span></span>
                    <p class="text-xs text-stone-400 leading-relaxed">
                        A modern peer-to-peer marketplace dedicated to authentic homemade items and domestic small businesses across Sri Lanka.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-3 text-xs uppercase tracking-wider">Categories</h4>
                    <ul class="space-y-2 text-xs text-stone-400">
                        <li><a href="/?category=home-decor" class="hover:text-amber-400">Home Decor & Candles</a></li>
                        <li><a href="/?category=textiles-handloom" class="hover:text-amber-400">Handloom & Batik</a></li>
                        <li><a href="/?category=homemade-food" class="hover:text-amber-400">Homemade Preserves & Food</a></li>
                        <li><a href="/?category=handicrafts-art" class="hover:text-amber-400">Crafts & Woodwork</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-3 text-xs uppercase tracking-wider">Trust & Safety</h4>
                    <ul class="space-y-2 text-xs text-stone-400">
                        <li>Artisan Verification Program</li>
                        <li>Homemade Quality Checklist</li>
                        <li>Buyer Protection Tips</li>
                        <li>No Middleman Commissions</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-3 text-xs uppercase tracking-wider">Start Selling</h4>
                    <p class="text-xs text-stone-400 leading-relaxed mb-3">
                        Do you bake, sew, paint, or craft from home? Reach thousands of local buyers with free ad listings.
                    </p>
                    <a href="{{ route('listings.create') }}" class="inline-block text-xs font-bold text-amber-400 hover:text-amber-300 underline">
                        List your homemade product &rarr;
                    </a>
                </div>
            </div>
            <div class="pt-6 text-center text-xs text-stone-500">
                &copy; {{ date('Y') }} CraftNest Marketplace. Clean, clutter-free alternative to legacy classifieds.
            </div>
        </div>
    </footer>
</body>
</html>

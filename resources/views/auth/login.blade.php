<x-app-layout>

{{-- ============================================================
     LOGIN PAGE – two-column split layout
     Left  (60%) : feature highlights + marketplace watermark
     Right (40%) : login form
     Below card  : CTA for posting a free ad
     ============================================================ --}}

<section class="min-h-screen bg-[#F5F7FA] flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

    {{-- ── WHITE CARD ──────────────────────────────────────────────── --}}
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.08)] overflow-hidden flex flex-col md:flex-row">

        {{-- ════════════════════════════════════════════════════════════
             LEFT COLUMN – Feature Highlights (60%)
             ════════════════════════════════════════════════════════════ --}}
        <div class="relative md:w-3/5 p-8 sm:p-10 flex flex-col justify-center order-2 md:order-1 overflow-hidden min-h-[420px]">

            {{-- ── Real background photo ───────────────────────────────── --}}
            {{--
                 HOW TO CUSTOMISE THE BACKGROUND IMAGE
                 ─────────────────────────────────────────────────────────
                 • Swap photo:  change src to any image in /public/images/
                 • Overlay darkness: edit the gradient classes on the div below
                   e.g. "from-gray-900/90" = darker,  "from-gray-900/60" = lighter
                 • Shift photo focus: add  object-[center_top]  to the img tag
                 ─────────────────────────────────────────────────────────
            --}}
            <div class="absolute inset-0 z-0" aria-hidden="true">
                <img
                    src="{{ asset('images/marketplace-bg.jpg') }}"
                    alt=""
                    class="w-full h-full object-cover object-center select-none"
                >
                {{-- Dark gradient overlay — keeps text readable over the photo --}}
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-gray-900/70 to-teal-900/75"></div>
            </div>

            {{-- ── Content (sits above photo + overlay) ─────────────────── --}}
            <div class="relative z-10">

                {{-- Heading --}}
                <h1 class="text-3xl font-bold text-white leading-tight mb-3 drop-shadow">
                    Log in – to post your free ad
                </h1>
                <p class="text-gray-300 text-sm leading-relaxed mb-10 max-w-md">
                    Please login to your classified account. You can view your ads
                    and account details.
                </p>

                {{-- Feature list --}}
                <ul class="space-y-6">

                    {{-- Item 1: Post ads --}}
                    <li class="flex items-start gap-4">
                        <span class="shrink-0 w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center shadow-sm">
                            {{-- Tag icon --}}
                            <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5a1.992 1.992 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.992 1.992 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </span>
                        <div class="pt-0.5">
                            <p class="font-semibold text-white">Post your new ads.</p>
                            <p class="text-xs text-gray-300 mt-0.5">List items for free and reach thousands of local buyers.</p>
                        </div>
                    </li>

                    {{-- Item 2: Update / promote --}}
                    <li class="flex items-start gap-4">
                        <span class="shrink-0 w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center shadow-sm">
                            {{-- Pencil / edit icon --}}
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </span>
                        <div class="pt-0.5">
                            <p class="font-semibold text-white">Update your posted ads and promote.</p>
                            <p class="text-xs text-gray-300 mt-0.5">Edit details, add photos, and boost visibility instantly.</p>
                        </div>
                    </li>

                    {{-- Item 3: Favourites --}}
                    <li class="flex items-start gap-4">
                        <span class="shrink-0 w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center shadow-sm">
                            {{-- Star icon --}}
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </span>
                        <div class="pt-0.5">
                            <p class="font-semibold text-white">Keep track of your favorite ads.</p>
                            <p class="text-xs text-gray-300 mt-0.5">Save listings and revisit them any time from your dashboard.</p>
                        </div>
                    </li>

                </ul>
            </div>{{-- /z-10 content --}}
        </div>

        {{-- ════════════════════════════════════════════════════════════
             RIGHT COLUMN – Login Form (40%)
             ════════════════════════════════════════════════════════════ --}}
        <div class="md:w-2/5 bg-white p-8 sm:p-10 flex flex-col justify-center order-1 md:order-2 border-t md:border-t-0 md:border-l border-gray-100">

            {{-- Form header --}}
            <div class="flex items-center gap-2 mb-7">
                <span class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                    {{-- User icon --}}
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <h2 class="text-lg font-bold text-gray-800">User login</h2>
            </div>

            {{-- ── Session / error flash messages ───────────────────── --}}
            @if (session('status'))
                <div class="mb-5 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium text-center" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 p-3 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-700 text-sm font-semibold" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- ── Login Form ────────────────────────────────────────── --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address :
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full px-3 py-2 border rounded-md text-sm text-gray-800 placeholder-gray-400 outline-none transition
                               {{ $errors->has('email') ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-200' : 'border-gray-300 focus:border-teal-600 focus:ring-2 focus:ring-teal-100' }}"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600 font-medium" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password :
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Password"
                        required
                        autocomplete="current-password"
                        class="w-full px-3 py-2 border rounded-md text-sm text-gray-800 placeholder-gray-400 outline-none transition
                               {{ $errors->has('password') ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-200' : 'border-gray-300 focus:border-teal-600 focus:ring-2 focus:ring-teal-100' }}"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-600 font-medium" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
                        >
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-semibold text-sm rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                >
                    Login
                </button>

            </form>

            {{-- Forgot password --}}
            @if (Route::has('password.request'))
                <div class="mt-4 text-center">
                    <a href="{{ route('password.request') }}"
                       class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                        {{-- Key icon --}}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Forgot password?
                    </a>
                </div>
            @endif

            {{-- Divider --}}
            <hr class="my-6 border-gray-100">

            {{-- Sign up link --}}
            <p class="text-sm text-gray-600 text-center">
                Don't have an account yet?
                <a href="{{ route('register') }}"
                   class="font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                    Sign up now!
                </a>
            </p>

        </div>{{-- /right column --}}
    </div>{{-- /white card --}}


    {{-- ══════════════════════════════════════════════════════════════════
         BELOW-CARD CTA SECTION
         ══════════════════════════════════════════════════════════════════ --}}
    <div class="mt-12 text-center px-4">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">
            Do you have something to sell?
        </h2>
        <p class="text-gray-500 text-sm mb-7">
            Post your ad on veyangoda.lk
        </p>

        <div class="inline-flex items-center gap-3">
            <span class="text-2xl select-none" aria-hidden="true">👈</span>
            <a
                href="{{ route('listings.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white font-bold text-sm rounded-lg shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400"
            >
                Post your ad now
            </a>
            <span class="text-2xl select-none" aria-hidden="true">👉</span>
        </div>
    </div>

</section>

</x-app-layout>

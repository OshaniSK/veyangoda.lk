@props(['locations' => [], 'categories' => []])

<section class="relative isolate overflow-visible bg-low-poly px-4 py-7 sm:px-6 sm:py-9 lg:py-10 text-center min-h-[250px] sm:min-h-[280px] md:min-h-[300px] flex items-center justify-center z-20">
    <!-- Ambient dark gradient overlay to ensure text contrast while letting geometric pattern show -->
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-b from-black/35 via-black/25 to-black/45"></div>
        <div aria-hidden="true" class="absolute inset-0 opacity-[0.07]" style="background-image: repeating-linear-gradient(30deg, transparent 0 54px, rgba(255,255,255,.5) 55px, transparent 56px 108px), repeating-linear-gradient(150deg, transparent 0 54px, rgba(255,255,255,.35) 55px, transparent 56px 108px); background-size: 112px 96px;"></div>
    </div>

    <div class="relative z-10 mx-auto w-full max-w-7xl">
        <!-- Main Heading: Compact scale with crisp hierarchy -->
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white drop-shadow-sm">
            Welcome to Veyangoda.lk
        </h1>

        <!-- Subheading: Tight vertical rhythm -->
        <p class="mx-auto mt-1.5 mb-5 sm:mb-6 max-w-xl text-xs sm:text-sm md:text-base font-medium leading-relaxed text-white/90 drop-shadow-sm">
            Sell in Seconds. Buy with Confidence
        </p>

        <!-- Search Bar Row: Compact padding & height -->
        <div class="mx-auto max-w-5xl overflow-visible rounded-xl bg-white p-1.5 sm:p-2 shadow-xl shadow-emerald-950/20 ring-1 ring-black/5">
            <form action="{{ route('listings.index') }}" method="GET" class="flex flex-col gap-1.5 sm:gap-2 overflow-visible lg:flex-row lg:items-center">
                <!-- Keyword Input -->
                <div class="relative flex min-w-0 flex-1 items-center overflow-visible">
                    <svg aria-hidden="true" class="pointer-events-none absolute left-3.5 h-5 w-5 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input
                        type="text"
                        name="search"
                        placeholder="What are you looking for?"
                        value="{{ request('search') }}"
                        class="w-full rounded-lg border-0 py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <!-- Location Picker -->
                <div class="relative min-w-[190px] overflow-visible lg:w-60 lg:border-l lg:border-gray-200 lg:pl-2.5">
                    <x-location-picker
                        :locations="$locations"
                        :value="request('location')"
                        placeholder="Select Location"
                        trigger-class="rounded-lg bg-white py-2.5 px-3 text-sm text-slate-700 hover:bg-slate-50 focus:ring-2 focus:ring-emerald-500"
                    />
                </div>

                <!-- Category Selector -->
                <div class="relative min-w-[170px] overflow-visible lg:w-52 lg:border-l lg:border-gray-200 lg:pl-2.5">
                    <select
                        name="category"
                        aria-label="Select a category"
                        class="w-full appearance-none rounded-lg border-0 bg-white py-2.5 pl-3.5 pr-9 text-sm text-slate-700 focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <svg aria-hidden="true" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                    </svg>
                </div>

                <!-- Search Button -->
                <button
                    type="submit"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#F59E0B] px-6 py-2.5 text-sm font-bold text-[#1E3A29] transition-colors hover:bg-amber-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2"
                >
                    <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Search</span>
                </button>
            </form>
        </div>
    </div>
</section>

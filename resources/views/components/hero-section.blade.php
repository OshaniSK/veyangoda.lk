@props(['locations' => [], 'categories' => []])

<section class="relative isolate overflow-hidden bg-low-poly px-4 py-14 text-center sm:px-6 sm:py-20 lg:px-8">
    <div aria-hidden="true" class="absolute inset-0 bg-black/30"></div>
    <div aria-hidden="true" class="absolute inset-0 opacity-[0.08]" style="background-image: repeating-linear-gradient(30deg, transparent 0 54px, rgba(255,255,255,.5) 55px, transparent 56px 108px), repeating-linear-gradient(150deg, transparent 0 54px, rgba(255,255,255,.35) 55px, transparent 56px 108px); background-size: 112px 96px;"></div>

    <div class="relative z-10 mx-auto max-w-7xl">
        <h1 class="mb-4 text-4xl font-extrabold text-white sm:text-5xl lg:text-6xl">
            Welcome to Veyangoda.lk
        </h1>
        <p class="mx-auto mb-8 max-w-2xl text-base font-medium leading-relaxed text-white/90 sm:mb-10 sm:text-lg">
            Buy and sell everything from homemade food to real estate safely in Sri Lanka.
        </p>

        <div class="mx-auto max-w-4xl rounded-xl bg-white p-2 shadow-2xl shadow-emerald-950/20 sm:p-3">
            <form action="{{ route('listings.index') }}" method="GET" class="flex flex-col gap-2 lg:flex-row">
                <div class="relative flex min-w-0 flex-1 items-center">
                    <svg aria-hidden="true" class="absolute left-4 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" name="search" placeholder="What are you looking for?" value="{{ request('search') }}" class="w-full rounded-lg border-0 py-3.5 pl-12 pr-4 text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="relative min-w-0 lg:w-56">
                    <svg aria-hidden="true" class="absolute left-4 top-1/2 z-10 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <select name="location" aria-label="Select District or City" class="w-full appearance-none rounded-lg border-0 bg-white py-3.5 pl-12 pr-10 text-slate-700 focus:ring-2 focus:ring-emerald-500">
                        <option value="">Select District/City</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}" @selected(request('location') === $location)>{{ $location }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="relative min-w-0 lg:w-52">
                    <select name="category" aria-label="Select a category" class="w-full appearance-none rounded-lg border-0 bg-white px-4 py-3.5 pr-10 text-slate-700 focus:ring-2 focus:ring-emerald-500">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <svg aria-hidden="true" class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                </div>

                <button type="submit" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-accent-yellow px-7 py-3.5 font-bold text-dark-green transition-colors hover:bg-yellow-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:ring-offset-2">
                    <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Search
                </button>
            </form>
        </div>
    </div>
</section>

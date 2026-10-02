<x-app-layout>
    <x-hero-section :locations="$locations" :categories="$categories" />

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        <x-category-grid :categories="$categories" />

        <section class="mb-12 overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm">
            <div class="grid items-center gap-8 p-6 sm:p-9 lg:grid-cols-[0.9fr_1.1fr] lg:gap-12 lg:p-12">
                <div class="order-2 flex min-h-48 items-center justify-center rounded-xl bg-emerald-50 sm:min-h-56 lg:order-1" aria-hidden="true">
                    <svg class="h-44 w-52 sm:h-52 sm:w-60" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M31 164h178" stroke="#A7F3D0" stroke-width="5" stroke-linecap="round"/>
                        <rect x="42" y="111" width="156" height="51" rx="7" fill="#D1FAE5" stroke="#047857" stroke-width="3"/>
                        <path d="M33 111h174l-12-23H45l-12 23Z" fill="#FACC15" stroke="#064E3B" stroke-width="3" stroke-linejoin="round"/>
                        <path d="M51 89V69h138v20" stroke="#064E3B" stroke-width="3" stroke-linecap="round"/>
                        <path d="M63 111V92h21v19m23 0V92h21v19m23 0V92h21v19" fill="#fff" stroke="#047857" stroke-width="2.5"/>
                        <circle cx="121" cy="43" r="17" fill="#F4C7A1" stroke="#064E3B" stroke-width="3"/>
                        <path d="M104 43c0-14 8-22 20-22 10 0 17 7 17 19-6-5-13-7-21-6-5 1-10 4-16 9Z" fill="#334155"/>
                        <path d="M102 107V80c0-12 8-19 19-19s20 7 20 19v27" fill="#34D399" stroke="#064E3B" stroke-width="3"/>
                        <path d="m103 77-18 19m55-19 17 19" stroke="#F4C7A1" stroke-width="8" stroke-linecap="round"/>
                        <path d="M81 91h19v20H81z" fill="#FB923C" stroke="#9A3412" stroke-width="2.5"/>
                        <path d="M84 91c1-8 12-8 13 0" stroke="#9A3412" stroke-width="2.5"/>
                        <path d="M161 97h20v14h-20z" fill="#60A5FA" stroke="#1D4ED8" stroke-width="2.5"/>
                        <path d="m166 97 5-8 5 8" stroke="#1D4ED8" stroke-width="2.5" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="order-1 text-center lg:order-2 lg:text-left">
                    <p class="mb-3 text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">For local makers and sellers</p>
                    <h2 class="text-2xl font-extrabold leading-tight text-slate-900 sm:text-3xl">Turn Your Creativity into Income.</h2>
                    <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-slate-600 sm:text-base lg:mx-0">Join thousands of local artisans and sellers on Veyangoda.lk. It's free and takes seconds.</p>
                    <a href="{{ route('listings.create') }}" class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-accent-yellow px-6 py-3.5 font-bold text-dark-green shadow-sm transition hover:bg-yellow-300 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2">
                        Start Selling Now
                        <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </section>

        @if($listings->count() > 0)
            <section class="mb-12">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">Fresh from the community</p>
                        <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">Featured Ads</h2>
                    </div>
                    <a href="{{ route('listings.index') }}" class="text-sm font-semibold text-emerald-800 hover:underline">View All</a>
                </div>
                <div class="no-scrollbar flex snap-x snap-mandatory gap-4 overflow-x-auto pb-4">
                    @foreach($listings->take(6) as $listing)
                        <a href="{{ route('listings.show', $listing->slug) }}" class="group flex w-64 shrink-0 snap-start flex-col overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:w-72">
                            <div class="aspect-[4/3] w-full overflow-hidden bg-slate-100">
                                <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <div class="flex flex-1 flex-col p-4">
                                <h3 class="mb-1 line-clamp-2 text-sm font-bold text-slate-900 transition-colors group-hover:text-emerald-800">{{ $listing->title }}</h3>
                                <p class="mb-2 text-base font-bold text-emerald-800">Rs {{ number_format($listing->price, 2) }}</p>
                                <div class="mt-auto flex items-center justify-between text-xs text-slate-500">
                                    <span>{{ $listing->location }}</span>
                                    <span>{{ $listing->created_at->diffForHumans(null, true) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-app-layout>

@props(['ads'])

@if($ads->count() > 0)
    <section class="mb-10 bg-white p-6 rounded-2xl border border-[#E5E5E5] shadow-sm">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <p class="mb-1 text-[10px] font-bold uppercase tracking-[0.16em] text-[#008060]">Fresh from the community</p>
                <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">Featured Ads</h2>
            </div>
            <a href="{{ route('listings.index', ['featured' => 1]) }}" class="text-sm font-semibold text-[#008060] hover:underline">View All</a>
        </div>
        
        <div class="relative group">
            <div class="no-scrollbar flex snap-x snap-mandatory gap-4 overflow-x-auto pb-4" id="featured-carousel">
                @foreach($ads as $listing)
                    <div class="w-64 sm:w-72 shrink-0 snap-start">
                        <x-ad-card :listing="$listing" layout="grid" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

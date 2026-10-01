<div 
    x-data="{
        isOpen: false,
        isAuth: {{ auth()->check() ? 'true' : 'false' }},
        listingId: null,
        listingTitle: '',
        listingPrice: '',
        sellerName: '',
        sellerId: null,
        phone: '',
        whatsapp: '',
        revealedPhone: false,
        
        open(data) {
            this.listingId = data.listingId;
            this.listingTitle = data.title;
            this.listingPrice = data.price;
            this.sellerName = data.sellerName;
            this.sellerId = data.sellerId;
            this.phone = data.phone;
            this.whatsapp = data.whatsapp;
            this.revealedPhone = false;
            this.isOpen = true;
        },
        close() {
            this.isOpen = false;
        },
        
        async logContact(type) {
            if (!this.isAuth) return;
            try {
                await fetch('{{ route('contact-requests.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        listing_id: this.listingId,
                        type: type
                    })
                });
            } catch (e) {
                console.error('Failed to log contact', e);
            }
        },
        
        handlePhoneClick() {
            this.revealedPhone = true;
            this.logContact('call');
        },
        
        handleWhatsappClick() {
            this.logContact('whatsapp');
            window.open(this.whatsapp, '_blank', 'noopener,noreferrer');
        }
    }"
    @open-contact-modal.window="open($event.detail)"
    @keydown.escape.window="close()"
    x-show="isOpen"
    class="relative z-50"
    style="display: none;"
    x-cloak
>
    {{-- Backdrop --}}
    <div 
        x-show="isOpen"
        x-transition.opacity
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
        @click="close()"
    ></div>

    {{-- Dialog --}}
    <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 flex items-center justify-center">
        <div 
            x-show="isOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            class="relative w-full max-w-lg bg-surface-card rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-100 text-left overflow-hidden"
            @click.stop
        >
            {{-- Close Button --}}
            <button type="button" @click="close()" class="absolute top-5 right-5 text-slate-400 hover:text-brand-blue p-1.5 rounded-full hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            {{-- Header --}}
            <div class="mb-6 pb-4 border-b border-slate-100">
                <span class="text-xs font-semibold text-brand-blue uppercase tracking-wider text-grad-primary">Inquiry for Maker</span>
                <h3 class="text-lg font-bold text-ink-primary mt-1 line-clamp-1" x-text="listingTitle"></h3>
                <p class="text-sm font-semibold text-brand-blue mt-1" x-text="listingPrice"></p>
            </div>

            {{-- Guest View --}}
            <template x-if="!isAuth">
                <div class="space-y-5">
                    <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5 text-center">
                        <div class="w-12 h-12 mx-auto rounded-full bg-brand-blue text-white flex items-center justify-center mb-3 shadow-brand-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h4 class="text-base font-bold text-ink-primary">Sign in to Contact Maker</h4>
                        <p class="text-xs text-ink-secondary mt-1 leading-relaxed max-w-sm mx-auto">
                            To ensure safety and protect our small home-based artisans from spam, please sign in or register before calling or messaging.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a :href="'{{ Route::has('login') ? route('login') : url('/login') }}?intended=' + encodeURIComponent(window.location.href)"
                           class="btn-primary flex-1">
                            Sign In
                        </a>
                        <a :href="'{{ Route::has('register') ? route('register') : url('/register') }}?intended=' + encodeURIComponent(window.location.href)"
                           class="btn-ghost flex-1">
                            Create Account
                        </a>
                    </div>
                </div>
            </template>

            {{-- Authenticated View --}}
            <template x-if="isAuth">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        
                        {{-- Phone Button --}}
                        <div class="flex flex-col">
                            <template x-if="!revealedPhone">
                                <button type="button" @click="handlePhoneClick()" class="btn-ghost w-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>Show Phone No.</span>
                                </button>
                            </template>
                            <template x-if="revealedPhone">
                                <a :href="'tel:' + phone" class="btn-primary w-full !bg-emerald-600 !shadow-none hover:!bg-emerald-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span x-text="phone || 'No phone provided'"></span>
                                </a>
                            </template>
                        </div>

                        {{-- WhatsApp Button --}}
                        <button type="button" @click="handleWhatsappClick()" class="btn-primary w-full !bg-emerald-500 !shadow-none hover:!bg-emerald-600">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.97.531 1.77.82 2.802.82 3.178 0 5.767-2.587 5.767-5.766.001-3.187-2.575-5.806-5.773-5.806zm0 10.42c-.93 0-1.74-.262-2.48-.73l-.178-.106-1.57.412.42-1.53-.116-.184c-.524-.834-.8-1.545-.8-2.516 0-2.617 2.129-4.746 4.746-4.746 2.614 0 4.742 2.133 4.742 4.746 0 2.616-2.126 4.654-4.764 4.654z"/></svg>
                            <span>WhatsApp</span>
                        </button>
                    </div>

                    {{-- Chat Form --}}
                    <div class="pt-4 border-t border-slate-100">
                        <label class="block text-xs font-semibold text-ink-secondary mb-1.5">Direct Message to Maker</label>
                        @auth
                        <form method="POST" action="{{ route('messages.store') }}" @submit="logContact('message')">
                            @csrf
                            <input type="hidden" name="receiver_id" :value="sellerId">
                            <input type="hidden" name="listing_id" :value="listingId">
                            
                            <textarea name="message" rows="3" required
                                      class="input-brand mb-3"
                                      placeholder="Hi, I am interested in this item. Is it still available?"></textarea>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="btn-primary">
                                    Send Message
                                </button>
                            </div>
                        </form>
                        @endauth
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

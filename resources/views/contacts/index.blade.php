<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <div class="max-w-7xl mx-auto mb-8">
            <nav class="flex items-center gap-2 text-xs font-medium text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                <span>/</span>
                <span class="text-gray-900 font-bold">Contact Us</span>
            </nav>
        </div>

        <div class="max-w-7xl mx-auto">
            
            <!-- Success Flash Message -->
            @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-primary p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- LEFT COLUMN: Company Details (Span 5) -->
                <div class="lg:col-span-5 bg-white rounded-2xl shadow-card p-8 border border-gray-100 h-full">
                    <h1 class="text-3xl font-extrabold text-dark mb-4 tracking-tight">Contact Us</h1>
                    <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                        For any inquiries, feel free to get in touch with us using the contact details below. Our support team is always ready to assist you.
                    </p>

                    <div class="space-y-6">
                        <!-- Hot Line -->
                        <div class="flex items-start gap-4 p-4 bg-orange-50 rounded-xl border border-orange-100">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide">24/7 Hot Line</h3>
                                <p class="text-2xl font-extrabold bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent mt-1">
                                    0112 345 678
                                </p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-dark">Head Office</h3>
                                <p class="text-sm text-gray-600 mt-1">No. 123, Main Street,<br>Veyangoda, Sri Lanka.</p>
                            </div>
                        </div>

                        <!-- Branches -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-dark">Branches</h3>
                                <p class="text-sm text-gray-600 mt-1">Colombo: 0112 987 654<br>Kandy: 0812 345 678</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-dark">Email Support</h3>
                                <a href="mailto:support@veyangoda.lk" class="text-sm text-primary hover:underline font-medium mt-1 inline-block">support@veyangoda.lk</a>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="pt-6 border-t border-gray-100">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Follow Us</h3>
                            <div class="flex gap-3">
                                <!-- WhatsApp -->
                                <a href="#" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.148.563 4.254 1.633 6.108L.092 23.82l5.813-1.524A11.954 11.954 0 0012.031 24c6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm5.952 17.151c-.247.697-1.42 1.353-1.957 1.455-.536.102-1.229.17-3.923-1.127-3.238-1.558-5.342-4.869-5.503-5.083-.162-.214-1.314-1.748-1.314-3.332 0-1.583.824-2.36 1.127-2.678.304-.319.658-.399.877-.399.219 0 .438.005.626.014.204.01.478-.076.745.566.279.673.957 2.344 1.042 2.515.085.17.142.368.034.582-.108.214-.165.346-.328.536-.162.19-.344.417-.492.573-.162.17-.336.357-.142.69.194.333.86 1.42 1.844 2.298 1.272 1.134 2.327 1.488 2.67 1.658.344.17.545.143.748-.094.204-.236.877-1.022 1.111-1.373.235-.351.469-.293.784-.176.314.117 1.996.938 2.338 1.109.344.17.573.255.658.397.085.143.085.83-.162 1.527z"/></svg>
                                </a>
                                <!-- Facebook -->
                                <a href="#" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:scale-110 transition-transform shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                <!-- Instagram -->
                                <a href="#" class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#FD1D1D] via-[#E1306C] to-[#C13584] text-white flex items-center justify-center hover:scale-110 transition-transform shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                </a>
                                <!-- TikTok -->
                                <a href="#" class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center hover:scale-110 transition-transform shadow-sm">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>
                                </a>
                                <!-- YouTube -->
                                <a href="#" class="w-10 h-10 rounded-full bg-[#FF0000] text-white flex items-center justify-center hover:scale-110 transition-transform shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Feedback Form (Span 7) -->
                <div class="lg:col-span-7 bg-white rounded-2xl shadow-card p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold text-dark mb-6">Send Us Your Feedback</h2>
                    
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <!-- Name & Email Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-dark mb-1">Your Name *</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-dark outline-none transition-colors @error('name') border-red-500 @enderror">
                                @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-dark mb-1">Email Address *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-dark outline-none transition-colors @error('email') border-red-500 @enderror">
                                @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-dark mb-1">Subject *</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-dark outline-none transition-colors @error('subject') border-red-500 @enderror">
                            @error('subject') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-dark mb-1">Your Message *</label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-dark outline-none transition-colors resize-y @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-3.5 px-6 rounded-lg bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white font-bold text-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Submit Your Message
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

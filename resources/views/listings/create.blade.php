<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Post an Advertisement - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen flex flex-col font-sans antialiased bg-gray-50 text-[#0F172A]">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#6C2BD9] via-[#2563EB] to-[#06B6D4]">
                    CraftNest
                </span>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                    Back to Home
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        
        <!-- Header Section -->
        <div class="max-w-3xl mx-auto mb-8 text-center sm:text-left">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold mb-4 shadow-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                </svg>
                <span>Free Domestic Listing</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-[#0F172A] tracking-tight">
                Post an Advertisement
            </h1>
            <p class="text-base sm:text-lg text-[#64748B] mt-2">
                Share your homemade creations with thousands of buyers across Sri Lanka.
            </p>
        </div>

        <!-- Form Card Container -->
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-10">
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 border-l-4 border-green-500 text-green-800 text-sm font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-800 text-sm font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- 1. Product Title -->
                <div x-data="{ title: '{{ addslashes(old('title', '')) }}' }">
                    <div class="flex items-center justify-between mb-2">
                        <label for="title" class="block text-sm font-bold text-[#0F172A]">
                            Item Title <span class="text-[#2563EB]">*</span>
                        </label>
                        <span class="text-xs font-medium text-[#64748B]" x-text="(100 - title.length) + ' characters left'"></span>
                    </div>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        maxlength="100"
                        x-model="title"
                        required 
                        placeholder="e.g., Hand-Poured Organic Soy Wax Candle"
                        class="w-full text-base rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/20 p-3.5 text-[#0F172A] placeholder-[#64748B] transition-colors outline-none @error('title') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                    >
                    @error('title')
                        <p class="text-sm text-red-600 mt-2 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- 2. Category & Price (2 Columns) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Category Select -->
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-[#0F172A] mb-2">
                            Category <span class="text-[#2563EB]">*</span>
                        </label>
                        <div class="relative">
                            <select 
                                id="category_id" 
                                name="category_id" 
                                required
                                class="w-full appearance-none text-base rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/20 p-3.5 pr-10 text-[#0F172A] bg-white transition-colors outline-none cursor-pointer @error('category_id') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                            >
                                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="text-sm text-red-600 mt-2 font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Price Input -->
                    <div>
                        <label for="price" class="block text-sm font-bold text-[#0F172A] mb-2">
                            Price (LKR) <span class="text-[#2563EB]">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-sm font-semibold text-[#64748B] pointer-events-none">Rs.</span>
                            <input 
                                type="number" 
                                id="price" 
                                name="price" 
                                step="0.01" 
                                min="0" 
                                value="{{ old('price') }}" 
                                required 
                                placeholder="2500"
                                class="w-full pl-12 pr-4 py-3.5 text-base rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/20 text-[#0F172A] placeholder-[#64748B] transition-colors outline-none @error('price') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                            >
                        </div>
                        @error('price')
                            <p class="text-sm text-red-600 mt-2 font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- 3. Location -->
                <div>
                    <label for="location" class="block text-sm font-bold text-[#0F172A] mb-2">
                        Location <span class="text-[#2563EB]">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#64748B]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            maxlength="100"
                            value="{{ old('location', auth()->user()->location_city ?? '') }}" 
                            required 
                            placeholder="e.g., Kandy, Galle, or Moratuwa"
                            class="w-full pl-12 pr-4 py-3.5 text-base rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/20 text-[#0F172A] placeholder-[#64748B] transition-colors outline-none @error('location') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                        >
                    </div>
                    @error('location')
                        <p class="text-sm text-red-600 mt-2 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- 4. Description -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="description" class="block text-sm font-bold text-[#0F172A]">
                            Description <span class="text-[#2563EB]">*</span>
                        </label>
                        <span class="text-xs font-medium text-[#64748B]">Min 20 characters</span>
                    </div>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="6" 
                        maxlength="5000"
                        required 
                        placeholder="Describe your domestic creation: ingredients, materials, dimensions, artisanal process, care instructions..."
                        class="w-full text-base rounded-lg border border-gray-300 focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/20 p-4 text-[#0F172A] placeholder-[#64748B] transition-colors outline-none leading-relaxed @error('description') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-2 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- 5. Image Upload (Drag & Drop Zone with AlpineJS) -->
                <div x-data="{ 
                    photoName: null, 
                    photoPreview: null,
                    fileSize: null,
                    isDragging: false,
                    clearPhoto() {
                        this.photoName = null;
                        this.photoPreview = null;
                        this.fileSize = null;
                        this.$refs.photo.value = '';
                    }
                }">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-bold text-[#0F172A]">
                            Product Photograph <span class="text-[#2563EB]">*</span>
                        </label>
                        <span class="text-xs font-medium text-[#64748B]">JPEG, PNG, WEBP (Max 2MB)</span>
                    </div>

                    <!-- Hidden native file input -->
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        accept="image/jpeg,image/png,image/jpg,image/webp" 
                        required
                        class="hidden"
                        x-ref="photo"
                        x-on:change="
                            if ($refs.photo.files.length > 0) {
                                const file = $refs.photo.files[0];
                                photoName = file.name;
                                fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        "
                    >

                    <!-- Drag & Drop Zone -->
                    <div 
                        @click="$refs.photo.click()"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="
                            isDragging = false;
                            if ($event.dataTransfer.files.length > 0) {
                                $refs.photo.files = $event.dataTransfer.files;
                                $refs.photo.dispatchEvent(new Event('change'));
                            }
                        "
                        :class="{ 'border-[#2563EB] bg-blue-50': isDragging, 'border-gray-300 hover:border-[#2563EB] bg-gray-50/50 hover:bg-gray-50': !isDragging }"
                        class="relative cursor-pointer border-2 border-dashed rounded-xl p-8 sm:p-10 text-center transition-all group @error('image') border-red-400 bg-red-50/30 @enderror"
                    >
                        <!-- Empty State -->
                        <div x-show="!photoPreview" class="space-y-4">
                            <div class="w-16 h-16 mx-auto rounded-full bg-blue-100 text-[#2563EB] flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-base font-semibold text-[#0F172A] group-hover:text-[#2563EB] transition-colors block mb-1">
                                    Upload Photos (Max 2MB)
                                </span>
                                <p class="text-sm text-[#64748B]">Drag and drop your file here, or click to browse</p>
                            </div>
                        </div>

                        <!-- Active Preview State -->
                        <div x-show="photoPreview" class="space-y-4" style="display: none;" @click.stop>
                            <div class="relative inline-block group/preview">
                                <img 
                                    :src="photoPreview" 
                                    alt="Preview" 
                                    class="w-48 h-48 sm:w-56 sm:h-56 object-cover rounded-xl mx-auto shadow-md border-4 border-white"
                                >
                                <button 
                                    type="button" 
                                    @click="clearPhoto()"
                                    class="absolute -top-3 -right-3 w-8 h-8 bg-white border border-red-100 text-red-600 rounded-full flex items-center justify-center hover:bg-red-50 hover:scale-110 shadow-lg transition-all"
                                    title="Remove photo"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <div>
                                <p class="font-semibold text-[#0F172A] truncate max-w-xs mx-auto" x-text="photoName"></p>
                                <span class="text-sm text-[#64748B]" x-text="fileSize"></span>
                            </div>
                            <button 
                                type="button" 
                                @click="$refs.photo.click()" 
                                class="text-sm font-semibold text-[#2563EB] hover:underline"
                            >
                                Change image
                            </button>
                        </div>
                    </div>

                    @error('image')
                        <p class="text-sm text-red-600 mt-2 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="pt-8 mt-8 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-4">
                    <a 
                        href="{{ route('home') }}" 
                        class="w-full sm:w-auto px-6 py-3.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-base font-semibold transition-colors text-center shadow-sm hover:shadow"
                    >
                        Cancel
                    </a>
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto sm:flex-1 px-6 py-3.5 rounded-lg bg-gradient-to-r from-[#6C2BD9] via-[#2563EB] to-[#06B6D4] text-white text-base font-semibold shadow-md hover:shadow-lg hover:opacity-90 hover:scale-[1.02] transition-all flex items-center justify-center gap-2"
                    >
                        <span>Publish Advertisement</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto py-8 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'CraftNest') }}. Supporting Sri Lankan small business artisans.</p>
    </footer>

</body>
</html>

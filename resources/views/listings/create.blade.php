<x-app-layout>
    <main class="min-h-[70vh] bg-slate-50 px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-3xl">
            <header class="mb-7">
                <span class="mb-4 inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-900">
                    <svg aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m9-9H3"/></svg>
                    Free Domestic Listing
                </span>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Post an Advertisement</h1>
                <p class="mt-2 max-w-2xl text-base leading-relaxed text-slate-600">Share your homemade creations with thousands of buyers across Sri Lanka.</p>
            </header>

            <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-lg shadow-slate-900/5 sm:p-8 lg:p-10">
                @if(session('success'))
                    <div role="status" class="mb-6 rounded-lg border-l-4 border-emerald-600 bg-emerald-50 p-4 text-sm font-semibold text-emerald-900">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div role="alert" class="mb-6 rounded-lg border-l-4 border-red-600 bg-red-50 p-4 text-sm font-semibold text-red-800">{{ session('error') }}</div>
                @endif

                <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div x-data="{ title: @js(old('title', '')) }">
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <label for="title" class="text-sm font-bold text-slate-800">Item Title <span class="text-red-600">*</span></label>
                            <span class="shrink-0 text-xs text-slate-500" x-text="(100 - title.length) + ' characters left'"></span>
                        </div>
                        <input id="title" name="title" type="text" maxlength="100" x-model="title" required value="{{ old('title') }}" placeholder="e.g., Hand-Poured Organic Soy Wax Candle" class="w-full rounded-lg border border-gray-300 px-4 py-3.5 text-base text-slate-800 placeholder:text-slate-500 focus:border-green-700 focus:outline-none focus:ring-2 focus:ring-green-700/25 @error('title') border-red-500 @enderror">
                        @error('title')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="category_id" class="mb-2 block text-sm font-bold text-slate-800">Category <span class="text-red-600">*</span></label>
                            <div class="relative">
                                <select id="category_id" name="category_id" required class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-3.5 pr-11 text-base text-slate-800 focus:border-green-700 focus:outline-none focus:ring-2 focus:ring-green-700/25 @error('category_id') border-red-500 @enderror">
                                    <option value="" disabled @selected(!old('category_id'))>Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <svg aria-hidden="true" class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                            </div>
                            @error('category_id')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="price" class="mb-2 block text-sm font-bold text-slate-800">Price (LKR) <span class="text-red-600">*</span></label>
                            <div class="relative">
                                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-500">Rs.</span>
                                <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" required placeholder="2500" class="w-full rounded-lg border border-gray-300 py-3.5 pl-12 pr-4 text-base text-slate-800 placeholder:text-slate-500 focus:border-green-700 focus:outline-none focus:ring-2 focus:ring-green-700/25 @error('price') border-red-500 @enderror">
                            </div>
                            @error('price')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="location" class="mb-2 block text-sm font-bold text-slate-800">Location <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <svg aria-hidden="true" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0ZM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <input id="location" name="location" type="text" maxlength="100" value="{{ old('location', auth()->user()->location_city ?? '') }}" required placeholder="e.g., Veyangoda, Kandy, or Galle" class="w-full rounded-lg border border-gray-300 py-3.5 pl-12 pr-4 text-base text-slate-800 placeholder:text-slate-500 focus:border-green-700 focus:outline-none focus:ring-2 focus:ring-green-700/25 @error('location') border-red-500 @enderror">
                        </div>
                        @error('location')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <label for="description" class="text-sm font-bold text-slate-800">Description <span class="text-red-600">*</span></label>
                            <span class="shrink-0 text-xs text-slate-500">Min 20 characters</span>
                        </div>
                        <textarea id="description" name="description" rows="6" maxlength="5000" required placeholder="Describe your domestic creation: ingredients, materials, dimensions, artisanal process, care instructions..." class="w-full resize-y rounded-lg border border-gray-300 px-4 py-3.5 text-base leading-relaxed text-slate-800 placeholder:text-slate-500 focus:border-green-700 focus:outline-none focus:ring-2 focus:ring-green-700/25 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div x-data="{
                        photos: [],
                        isDragging: false,
                        updatePhotos(files) {
                            this.photos.forEach((photo) => URL.revokeObjectURL(photo.preview));
                            this.photos = Array.from(files).slice(0, 5).map((file) => ({
                                name: file.name,
                                size: (file.size / 1024 / 1024).toFixed(2) + ' MB',
                                preview: URL.createObjectURL(file)
                            }));
                        },
                        clearPhotos() {
                            this.photos.forEach((photo) => URL.revokeObjectURL(photo.preview));
                            this.photos = [];
                            this.$refs.photos.value = '';
                        }
                    }">
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <label for="images" class="text-sm font-bold text-slate-800">Product Photographs <span class="text-red-600">*</span></label>
                            <span class="text-right text-xs text-slate-500">Up to 5 photos, 2MB each</span>
                        </div>
                        <input id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/jpg,image/webp" multiple required class="sr-only" x-ref="photos" x-on:change="updatePhotos($refs.photos.files)">

                        <div @click="$refs.photos.click()" @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="isDragging = false; if ($event.dataTransfer.files.length) { $refs.photos.files = $event.dataTransfer.files; updatePhotos($refs.photos.files); }" :class="isDragging ? 'border-emerald-700 bg-emerald-50' : 'border-dashed border-gray-300 bg-slate-50 hover:border-emerald-700 hover:bg-emerald-50/50'" class="cursor-pointer rounded-xl border-2 p-6 text-center transition-colors sm:p-8 @error('images') border-red-400 @enderror">
                            <div x-show="photos.length === 0" class="flex flex-col items-center">
                                <span class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-800">
                                    <svg aria-hidden="true" class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16.5A4.5 4.5 0 0 1 5.5 7.7 6 6 0 0 1 17 6a5 5 0 0 1 2.5 9.3M12 12v9m0-9-3.5 3.5M12 12l3.5 3.5"/></svg>
                                </span>
                                <span class="font-bold text-slate-800">Upload Photos (Max 2MB each)</span>
                                <span class="mt-1 text-sm text-slate-500">Drag and drop images here, or click to browse</span>
                            </div>
                            <div x-cloak x-show="photos.length > 0" @click.stop>
                                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-5">
                                    <template x-for="(photo, index) in photos" :key="photo.preview">
                                        <div class="min-w-0 text-left">
                                            <img :src="photo.preview" :alt="'Selected product photo ' + (index + 1)" class="aspect-square w-full rounded-lg border border-slate-200 object-cover" loading="lazy">
                                            <p class="mt-1 truncate text-xs font-medium text-slate-700" x-text="photo.name"></p>
                                            <p class="text-xs text-slate-500" x-text="photo.size"></p>
                                        </div>
                                    </template>
                                </div>
                                <div class="mt-4 flex justify-center gap-5">
                                    <button type="button" @click="$refs.photos.click()" class="text-sm font-semibold text-emerald-800 hover:underline">Change photos</button>
                                    <button type="button" @click="clearPhotos()" class="text-sm font-semibold text-red-700 hover:underline">Clear all</button>
                                </div>
                            </div>
                        </div>
                        @error('images')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
                        @error('images.*')<p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3.5 text-base font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-500 focus-visible:ring-offset-2">Cancel</a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#F59E0B] px-6 py-3.5 text-base font-bold text-green-900 shadow-sm transition hover:scale-[1.02] hover:bg-amber-500 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-600 focus-visible:ring-offset-2 sm:flex-1">
                            <span>Publish Advertisement</span>
                            <svg aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7 7 7-7 7"/></svg>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</x-app-layout>
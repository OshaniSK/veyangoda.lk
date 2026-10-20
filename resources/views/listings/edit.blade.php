<x-layouts.app :title="'Edit Listing - ' . $listing->title">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        <div class="mb-8">
            <a href="{{ route('my-listings.index') }}" class="inline-flex items-center text-sm font-semibold text-ink-secondary hover:text-brand-blue transition-colors mb-4">
                &larr; Back to My Listings
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-ink-primary font-serif">Edit Advertisement</h1>
        </div>

        @if($listing->isRejected())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 sm:p-5">
                <div class="flex items-start gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 mt-0.5">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-red-900">Advertisement Needs Revisions</h2>
                        <p class="text-xs text-red-700 mt-1 leading-relaxed">
                            <span class="font-semibold">Reason from Admin:</span> {{ $listing->rejection_reason }}
                        </p>
                        <p class="text-[11px] text-red-600 mt-1 font-medium">
                            Once you make your updates and click <strong>"Save & Resubmit"</strong> below, your ad will be sent back to the review queue.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="card p-6 sm:p-10">
            <form action="{{ route('my-listings.update', $listing) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div>
                    <label class="block text-xs font-bold text-ink-primary uppercase tracking-wider mb-1.5">Item Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $listing->title) }}" required maxlength="100" class="input-brand @error('title') border-rose-500 @enderror">
                    @error('title') <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-bold text-ink-primary uppercase tracking-wider mb-1.5">Category <span class="text-rose-500">*</span></label>
                        <select name="category_id" required class="input-brand @error('category_id') border-rose-500 @enderror">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label class="block text-xs font-bold text-ink-primary uppercase tracking-wider mb-1.5">Price (LKR) <span class="text-rose-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price', (float)$listing->price) }}" required step="0.01" min="0" class="input-brand @error('price') border-rose-500 @enderror">
                        @error('price') <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Location --}}
                <div>
                    <label class="block text-xs font-bold text-ink-primary uppercase tracking-wider mb-1.5">Location <span class="text-rose-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location', $listing->location) }}" required maxlength="100" class="input-brand @error('location') border-rose-500 @enderror">
                    @error('location') <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-bold text-ink-primary uppercase tracking-wider mb-1.5">Description <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="5" required class="input-brand @error('description') border-rose-500 @enderror">{{ old('description', $listing->description) }}</textarea>
                    @error('description') <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Image Update --}}
                <div x-data="{ photoName: null, photoPreview: null }">
                    <label class="block text-xs font-bold text-ink-primary uppercase tracking-wider mb-1.5">Update Photo (Optional)</label>
                    
                    <div class="flex items-start gap-4">
                        <img :src="photoPreview || '{{ $listing->image_url }}'" alt="Current Image" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                        
                        <div class="flex-1">
                            <input type="file" name="image" accept="image/*" class="hidden" x-ref="photo" @change="
                                const file = $refs.photo.files[0];
                                photoName = file.name;
                                const reader = new FileReader();
                                reader.onload = (e) => { photoPreview = e.target.result; };
                                reader.readAsDataURL(file);
                            ">
                            <button type="button" @click="$refs.photo.click()" class="btn-ghost !px-4 !py-2 text-xs">Choose New Image</button>
                            <p class="text-[11px] text-ink-secondary mt-2" x-text="photoName || 'Leave empty to keep current image.'"></p>
                            @error('image') <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <a href="{{ route('my-listings.index') }}" class="btn-ghost">Cancel</a>
                    <button type="submit" class="btn-primary">
                        {{ $listing->isRejected() ? 'Save & Resubmit for Review' : 'Save Changes' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

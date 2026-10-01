<x-admin-layout title="Category Management">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Create Form --}}
        <div class="lg:col-span-1">
            <div class="card p-6 sticky top-6">
                <h2 class="font-bold text-ink-primary mb-4">Add New Category</h2>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-ink-primary uppercase tracking-wider mb-1.5">Category Name</label>
                        <input type="text" name="name" required class="input-brand" placeholder="e.g. Handbags">
                        @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full">Create Category</button>
                </form>
            </div>
        </div>

        {{-- Categories List --}}
        <div class="lg:col-span-2">
            <div class="card overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider">Category Name</th>
                            <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider text-center">Listings</th>
                            <th class="px-6 py-4 text-xs font-semibold text-ink-secondary uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($categories as $category)
                            <tr class="hover:bg-slate-50/50" x-data="{ editing: false }">
                                <td class="px-6 py-4">
                                    {{-- Display Mode --}}
                                    <div x-show="!editing" class="font-bold text-ink-primary text-sm">{{ $category->name }}</div>
                                    
                                    {{-- Edit Mode --}}
                                    <form x-show="editing" x-cloak action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="name" value="{{ $category->name }}" required class="input-brand !py-1 !px-2 !text-sm">
                                        <button type="submit" class="btn-primary !py-1 !px-3 !text-xs">Save</button>
                                        <button type="button" @click="editing = false" class="btn-ghost !py-1 !px-3 !text-xs">Cancel</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-semibold text-slate-600 bg-slate-100 px-2 py-1 rounded-lg">
                                        {{ $category->listings_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button x-show="!editing" @click="editing = true" class="text-xs font-bold text-brand-blue bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded transition-colors">
                                        Edit
                                    </button>
                                    
                                    <form x-show="!editing" action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 px-2 py-1 rounded transition-colors" {{ $category->listings_count > 0 ? 'disabled title="Cannot delete category with listings" class="opacity-50 cursor-not-allowed text-rose-400 bg-rose-50 px-2 py-1 rounded"' : '' }}>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-admin-layout>

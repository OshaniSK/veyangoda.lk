<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    /**
     * Route: GET /admin/categories
     */
    public function index(): View
    {
        $categories = Category::withCount('listings')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Route: POST /admin/categories
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60', Rule::unique('categories', 'name')],
        ]);

        Category::create(['name' => $validated['name']]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category "' . $validated['name'] . '" created.');
    }

    /**
     * Route: PATCH /admin/categories/{category}
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60', Rule::unique('categories', 'name')->ignore($category->id)],
        ]);

        $category->update(['name' => $validated['name']]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated.');
    }

    /**
     * Route: DELETE /admin/categories/{category}
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Guard: don't delete if listings exist
        if ($category->listings()->exists()) {
            return back()->with('error', 'Cannot delete a category that has listings. Reassign them first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }
}

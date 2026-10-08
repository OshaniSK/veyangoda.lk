<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['subCategories' => function ($query) {
                $query->withCount('listings');
            }])
            ->firstOrFail();
        
        return view('categories.show', compact('category'));
    }
}

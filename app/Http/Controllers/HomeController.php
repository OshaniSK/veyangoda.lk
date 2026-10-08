<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the Ad-First Homepage Feed with active listings and categories.
     */
    public function index(Request $request): View
    {
        $query = Listing::query()
            ->with(['category', 'user', 'photos'])
            ->where('status', 'active');

        // 1. Keyword search (Title OR Description)
        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // 2. Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 3. Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . trim($request->location) . '%');
        }

        // 4. Price boundary filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Paginate active ads (12 per page)
        $listings = $query->latest()->paginate(12)->withQueryString();

        // Fetch categories with active listings count for quick horizontal nav
        $categories = Category::withCount(['listings' => fn ($q) => $q->where('status', 'active')])
            ->with('subCategories')
            ->orderBy('name')
            ->get();

        // Provide the 25 Sri Lankan districts in standard provincial order
        $locations = collect([
            'Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Matale', 'Nuwara Eliya', 
            'Galle', 'Matara', 'Hambantota', 'Jaffna', 'Mannar', 'Vavuniya', 
            'Mullaitivu', 'Kilinochchi', 'Batticaloa', 'Ampara', 'Trincomalee', 
            'Kurunegala', 'Puttalam', 'Anuradhapura', 'Polonnaruwa', 'Badulla', 
            'Monaragala', 'Rathnapura', 'Kegalle'
        ]);

        return view('welcome', compact('listings', 'categories', 'locations'));
    }
}

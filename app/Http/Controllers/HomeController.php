<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the Ad-First Homepage Feed with active listings and categories.
     */
    public function index(Request $request): View|JsonResponse
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

        // 2. Category & Subcategory filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category)
                  ->orWhere('name', $request->category);
            });
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('sub_category')) {
            $query->whereHas('subCategory', function ($q) use ($request) {
                $q->where('slug', $request->sub_category)
                  ->orWhere('name', $request->sub_category);
            });
        }

        if ($request->filled('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        // 3. Location filter
        if ($request->filled('location')) {
            $query->filterByLocation($request->location);
        }

        // 4. Price boundary filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }
        
        $requiresLoginForFollows = false;
        $isFilteringFollowed = false;

        // 5. Poster Type (All / Members = Followed Sellers)
        if ($request->query('poster_type') === 'members') {
            $isFilteringFollowed = true;
            if (auth()->check()) {
                $followedUserIds = auth()->user()->followings()->pluck('users.id')->toArray();
                $query->whereIn('user_id', $followedUserIds);
            } else {
                $requiresLoginForFollows = true;
                $query->whereRaw('1 = 0');
            }
        }

        // 6. Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'latest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        // Paginate active ads (25 per page as requested)
        $listings = $query->paginate(25)->withQueryString();

        // Fetch featured ads
        $featuredAds = Listing::with(['category', 'user', 'photos'])
            ->where('status', 'active')
            ->where('featured', true)
            ->latest()
            ->take(10)
            ->get();

        // Fetch categories with active listings count for sidebar
        $categories = Category::withCount(['listings' => fn ($q) => $q->where('status', 'active')])
            ->with(['subCategories' => function ($query) {
                $query->withCount(['listings' => fn ($q) => $q->where('status', 'active')]);
            }])
            ->orderBy('name')
            ->get();

        // Provide the 25 Sri Lankan districts with their local areas
        $locations = \App\Models\Location::with('areas')->districts()->orderBy('name')->get();

        // AJAX request — return only the listings partial as JSON
        if ($request->ajax()) {
            $html = view('partials.home-listings', compact('listings', 'categories', 'requiresLoginForFollows', 'isFilteringFollowed'))->render();
            return response()->json([
                'html'           => $html,
                'requires_login' => $requiresLoginForFollows,
                'total'          => $listings->total(),
                'pagination' => [
                    'current_page' => $listings->currentPage(),
                    'last_page'    => $listings->lastPage(),
                    'from'         => $listings->firstItem(),
                    'to'           => $listings->lastItem(),
                    'total'        => $listings->total(),
                ],
            ]);
        }

        return view('welcome', compact('listings', 'featuredAds', 'categories', 'locations', 'requiresLoginForFollows', 'isFilteringFollowed'));
    }
}

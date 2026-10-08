<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    /**
     * Display the paginated active ads feed.
     */
    public function index(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if ($request->filled('category')) {
            $slug = $request->query('category');
            return redirect()->route('listings.category', ['category_slug' => $slug, ...$request->except(['category'])]);
        } elseif ($request->filled('category_id')) {
            $category = Category::findOrFail($request->integer('category_id'));
            return redirect()->route('listings.category', ['category_slug' => $category->slug, ...$request->except(['category_id'])]);
        }

        $activeCategory = null;

        $query = Listing::query()
            ->with(['category', 'user', 'photos'])
            ->where('status', 'active');

        if ($activeCategory) {
            $query->where('category_id', $activeCategory->id);
        }

        $search = trim((string) $request->query('search', $request->query('q', '')));
        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . trim($request->query('location')) . '%');
        }

        $sort = $request->query('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderBy('price')->orderByDesc('created_at'),
            'price_desc' => $query->orderByDesc('price')->orderByDesc('created_at'),
            'popular' => $query->orderByDesc('views_count')->orderByDesc('created_at'),
            default => $query->latest(),
        };

        $listings = $query->paginate(12)->withQueryString();
        $categories = Category::withCount(['listings' => fn ($builder) => $builder->where('status', 'active')])
            ->orderBy('name')
            ->get();
        $locations = collect([
            'Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Matale', 'Nuwara Eliya', 
            'Galle', 'Matara', 'Hambantota', 'Jaffna', 'Mannar', 'Vavuniya', 
            'Mullaitivu', 'Kilinochchi', 'Batticaloa', 'Ampara', 'Trincomalee', 
            'Kurunegala', 'Puttalam', 'Anuradhapura', 'Polonnaruwa', 'Badulla', 
            'Monaragala', 'Rathnapura', 'Kegalle'
        ]);

        return view('listings.index', compact('listings', 'activeCategory', 'categories', 'locations', 'search', 'sort'));
    }

    public function category(Request $request, $category_slug, $sub_category_slug = null)
    {
        $category = Category::with(['subCategories'])->where('slug', $category_slug)->first();
        
        if (!$category) {
            // Fallback to listing show if category not found (to handle route overlap)
            $listing = Listing::where('slug', $category_slug)->firstOrFail();
            return $this->show($listing);
        }

        $query = Listing::with(['category', 'user', 'photos'])
            ->where('status', 'active')
            ->where('category_id', $category->id);

        $subCategory = null;
        $subCatSlug = $sub_category_slug ?? $request->input('sub_category');
        if ($subCatSlug) {
            $subCategory = \App\Models\SubCategory::where('slug', $subCatSlug)
                ->where('category_id', $category->id)
                ->first();
            
            if ($subCategory) {
                $query->where('sub_category_id', $subCategory->id);
                // Load filters for this sub-category
                $filters = \App\Models\CategoryFilter::with('options')
                    ->where('sub_category_id', $subCategory->id)
                    ->orderBy('sort_order')
                    ->get();
            } else {
                $filters = $category->filters()->with('options')->get();
            }
        } else {
            // Only load category-level filters
            $filters = $category->filters()->with('options')->whereNull('sub_category_id')->get();
        }

        $activeFilters = $request->all();

        foreach ($filters as $filter) {
            // In DB, filter_name is now "Min Price", we use a slugified version for request params
            $paramName = \Illuminate\Support\Str::slug($filter->filter_name, '_'); 
            // BUT wait, in previous seeder, we explicitly mapped them to simple names? No, the previous seeder just used "Min Price". 
            // In FoodAndFlavorsSeeder, I used `$filterData['label']` for filter_name.
            // Oh, wait, in FoodAndFlavorsSeeder, I used "Min Price" for label, but for others I used "Type", "Dietary".
            
            // To be safe and compatible with old and new logic:
            $requestKey = strtolower(str_replace(' ', '_', $filter->filter_name));
            if ($request->filled($requestKey)) {
                $value = $request->input($requestKey);
                
                if (in_array($requestKey, ['min_price', 'price_min'])) {
                    $query->where('price', '>=', $value);
                } elseif (in_array($requestKey, ['max_price', 'price_max'])) {
                    $query->where('price', '<=', $value);
                } elseif ($requestKey === 'year_min') {
                    $query->where('year_min', '>=', $value);
                } elseif ($requestKey === 'year_max') {
                    $query->where('year_max', '<=', $value);
                } elseif (in_array($requestKey, ['model', 'location'])) {
                    $query->where($requestKey, 'like', '%' . $value . '%');
                } else {
                    // Directly match column if it exists in fillables
                    // All new columns: item_type, dietary, shelf_life, cuisine, meal_type, flavor, curry_type, rice_type, spice_level, temperature, size, event_type, service_type, occasion
                    $query->where($requestKey, $value);
                }
            }
        }

        $search = trim((string) $request->query('search', $request->query('q', '')));
        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $listings = $query->latest()->paginate(12)->withQueryString();

        $filterOptions = []; // legacy empty array
        return view('listings.category', compact('category', 'subCategory', 'filters', 'filterOptions', 'listings', 'activeFilters'));
    }

    /**
     * Show the "Post Ad" form (Protected by auth middleware).
     */
    public function create(): View
    {
        $categories = Category::with('subCategories')->orderBy('name')->get();

        return view('listings.create', compact('categories'));
    }

    /**
     * Validate input via StoreListingRequest, handle image upload with uniqid(),
     * associate with authenticated user, and store listing inside a DB transaction.
     */
    public function store(StoreListingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $listing = DB::transaction(function () use ($validated, $request) {
            $uploadedImages = $request->file('images');
            $imagePaths = array_map(
                fn ($image) => $image->store('listings/photos', 'public'),
                $uploadedImages
            );

            $listing = Listing::create([
                'user_id' => auth()->id(),
                'category_id' => $validated['category_id'],
                'sub_category_id' => $validated['sub_category_id'] ?? null,
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . Str::random(6),
                'description' => $validated['description'],
                'price' => $validated['price'],
                'location' => $validated['location'],
                'image_path' => $imagePaths[0],
                'status' => 'active',
            ]);

            foreach ($imagePaths as $index => $imagePath) {
                $listing->photos()->create([
                    'photo_path' => $imagePath,
                    'order' => $index,
                ]);
            }

            return $listing;
        });

        return redirect()->route('home')
            ->with('success', 'Your advertisement "' . $listing->title . '" has been published successfully!');
    }

    /**
     * Display the specified listing details.
     */
    public function show(Listing $listing): View
    {
        $listing->load(['category', 'user.followers', 'photos']);

        // Increment views count
        $listing->incrementViews();

        // Get other listings from the same seller
        $otherListings = Listing::with(['category', 'photos'])
            ->where('user_id', $listing->user_id)
            ->where('id', '!=', $listing->id)
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        return view('listings.show', compact('listing', 'otherListings'));
    }
}

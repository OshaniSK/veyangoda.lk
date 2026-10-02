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
    public function index(Request $request): View
    {
        $activeCategory = null;
        if ($request->filled('category')) {
            $activeCategory = Category::where('slug', $request->query('category'))->firstOrFail();
        } elseif ($request->filled('category_id')) {
            $activeCategory = Category::findOrFail($request->integer('category_id'));
        }

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
        $locations = Listing::query()
            ->where('status', 'active')
            ->distinct()
            ->orderBy('location')
            ->pluck('location')
            ->filter();

        return view('listings.index', compact('listings', 'activeCategory', 'categories', 'locations', 'search', 'sort'));
    }

    /**
     * Show the "Post Ad" form (Protected by auth middleware).
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

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
        $listing->load(['category', 'user', 'photos']);

        // Increment views count
        $listing->incrementViews();

        return view('listings.show', compact('listing'));
    }
}

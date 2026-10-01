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
        return app(HomeController::class)->index($request);
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
            // 1. Generate unique filename: uniqid() + original extension
            $imageFile = $request->file('image');
            $uniqueFilename = uniqid('listing_', true) . '.' . $imageFile->getClientOriginalExtension();

            // 2. Store image in 'public/listings' disk directory
            $imagePath = $imageFile->storeAs('listings', $uniqueFilename, 'public');

            // 3. Create listing record associated with auth user
            return Listing::create([
                'user_id' => auth()->id(),
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']) . '-' . Str::random(6),
                'description' => $validated['description'],
                'price' => $validated['price'],
                'location' => $validated['location'],
                'image_path' => $imagePath,
                'status' => 'active',
            ]);
        });

        return redirect()->route('home')
            ->with('success', 'Your advertisement "' . $listing->title . '" has been published successfully!');
    }

    /**
     * Display the specified listing details.
     */
    public function show(Listing $listing): View
    {
        $listing->load(['category', 'user']);

        // Increment views count
        $listing->incrementViews();

        return view('listings.show', compact('listing'));
    }
}

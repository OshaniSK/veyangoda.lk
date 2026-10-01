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

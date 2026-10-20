<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MyListingController extends Controller
{
    /**
     * Show all listings created by the authenticated user.
     * Route: GET /my-listings
     */
    public function index(): View
    {
        $user = auth()->user();

        $listings = $user->listings()
            ->with(['category', 'subCategory'])
            ->latest()
            ->get();

        // Group listings, replacing "Food & Flavours" with the sub-category name
        $groupedListings = $listings->groupBy(function ($listing) {
            if ($listing->category->slug === 'food-and-flavours' && $listing->subCategory) {
                return $listing->subCategory->name;
            }
            return $listing->category->name;
        });

        // Summary stats
        $stats = [
            'total'    => $user->listings()->count(),
            'active'   => $user->listings()->where('status', 'active')->count(),
            'pending'  => $user->listings()->where('status', 'pending')->count(),
            'rejected' => $user->listings()->where('status', 'rejected')->count(),
            'sold'     => $user->listings()->where('status', 'sold')->count(),
        ];

        return view('listings.my-listings', compact('listings', 'groupedListings', 'stats'));
    }

    /**
     * Show edit form for a specific listing (owner only).
     * Route: GET /my-listings/{listing}/edit
     */
    public function edit(Listing $listing): View
    {
        $this->authorizeOwner($listing);

        $categories = Category::orderBy('name')->get();

        return view('listings.edit', compact('listing', 'categories'));
    }

    /**
     * Update the listing (owner only).
     * Route: PUT /my-listings/{listing}
     */
    public function update(Request $request, Listing $listing): RedirectResponse
    {
        $this->authorizeOwner($listing);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:100'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'price'       => ['required', 'numeric', 'min:0'],
            'location'    => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'min:20'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($validated, $request, $listing) {
            if ($request->hasFile('image')) {
                // Delete old image if it exists in local storage
                if ($listing->image_path && ! str_starts_with($listing->image_path, 'http')) {
                    Storage::disk('public')->delete($listing->image_path);
                }
                $imageFile       = $request->file('image');
                $uniqueFilename  = uniqid('listing_', true) . '.' . $imageFile->getClientOriginalExtension();
                $validated['image_path'] = $imageFile->storeAs('listings', $uniqueFilename, 'public');
                unset($validated['image']);
            }

            // If listing was rejected, editing and saving automatically resubmits it for review
            if ($listing->status === 'rejected') {
                $validated['status']           = 'pending';
                $validated['rejection_reason'] = null;
                $validated['approved_at']      = null;
                $validated['approved_by']      = null;
            }

            $listing->update($validated);
        });


        $flashMessage = $listing->status === 'pending'
            ? 'Listing "' . $listing->title . '" updated and resubmitted for admin approval.'
            : 'Listing "' . $listing->title . '" updated successfully.';

        return redirect()->route('my-listings.index')
            ->with('success', $flashMessage);
    }

    /**
     * Delete the listing (owner only).
     * Route: DELETE /my-listings/{listing}
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        $this->authorizeOwner($listing);

        DB::transaction(function () use ($listing) {
            if ($listing->image_path && ! str_starts_with($listing->image_path, 'http')) {
                Storage::disk('public')->delete($listing->image_path);
            }
            $listing->delete();
        });

        return redirect()->route('my-listings.index')
            ->with('success', 'Listing deleted successfully.');
    }

    /**
     * Mark the listing as sold (owner only).
     * Route: PATCH /my-listings/{listing}/sold
     */
    public function markSold(Listing $listing): RedirectResponse
    {
        $this->authorizeOwner($listing);

        $listing->update(['status' => 'sold']);

        return redirect()->route('my-listings.index')
            ->with('success', '"' . $listing->title . '" marked as sold.');
    }

    /**
     * Resubmit a rejected listing for re-review.
     * Status resets to 'pending'; rejection reason is cleared.
     * Route: PATCH /my-listings/{listing}/resubmit
     */
    public function resubmit(Listing $listing): RedirectResponse
    {
        $this->authorizeOwner($listing);

        if (! $listing->isRejected()) {
            return back()->with('error', 'Only rejected ads can be resubmitted.');
        }

        $listing->update([
            'status'           => 'pending',
            'rejection_reason' => null,
            'approved_at'      => null,
            'approved_by'      => null,
        ]);

        return redirect()->route('my-listings.index')
            ->with('success', '"' . $listing->title . '" has been resubmitted for review.');
    }

    // ── Private Helpers ──────────────────────────────────────────────────

    private function authorizeOwner(Listing $listing): void
    {
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'You do not own this listing.');
        }
    }
}

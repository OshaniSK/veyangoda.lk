<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminListingController extends Controller
{
    /**
     * Route: GET /admin/listings
     */
    public function index(Request $request): View
    {
        $query = Listing::with(['user', 'category'])->latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $listings = $query->paginate(20)->withQueryString();

        return view('admin.listings.index', compact('listings'));
    }

    /**
     * Approve a listing (set to active).
     * Route: PATCH /admin/listings/{listing}/approve
     */
    public function approve(Listing $listing): RedirectResponse
    {
        $listing->update(['status' => 'active']);

        return back()->with('success', 'Listing approved.');
    }

    /**
     * Reject a listing (set to pending).
     * Route: PATCH /admin/listings/{listing}/reject
     */
    public function reject(Listing $listing): RedirectResponse
    {
        $listing->update(['status' => 'pending']);

        return back()->with('success', 'Listing rejected and set to pending.');
    }

    /**
     * Delete a listing (admin override, any listing).
     * Route: DELETE /admin/listings/{listing}
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        if ($listing->image_path && ! str_starts_with($listing->image_path, 'http')) {
            Storage::disk('public')->delete($listing->image_path);
        }

        $listing->delete();

        return redirect()->route('admin.listings.index')
            ->with('success', 'Listing deleted.');
    }
}

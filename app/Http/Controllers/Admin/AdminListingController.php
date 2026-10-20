<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Notifications\AdApprovedNotification;
use App\Notifications\AdRejectedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminListingController extends Controller
{
    /**
     * Route: GET /admin/listings
     * Lists all listings (filterable by status). Defaults to showing pending first.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending'); // default to pending review

        $query = Listing::with(['user', 'category'])->latest();

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $listings     = $query->paginate(20)->withQueryString();
        $pendingCount = Listing::pending()->count();

        return view('admin.listings.index', compact('listings', 'pendingCount', 'status'));
    }

    /**
     * Approve a listing.
     * Route: PATCH /admin/listings/{listing}/approve
     */
    public function approve(Listing $listing): RedirectResponse
    {
        $listing->update([
            'status'      => 'active',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejection_reason' => null, // clear any previous reason
        ]);

        // Notify the seller — safely handle deleted seller accounts
        if ($seller = $listing->user) {
            try {
                $seller->notify(new AdApprovedNotification($listing));
            } catch (\Throwable $e) {
                Log::warning("Could not send AdApprovedNotification for listing #{$listing->id}: " . $e->getMessage());
            }
        }

        Log::info("Admin #{auth()->id()} approved listing #{$listing->id} \"{$listing->title}\".");

        return back()->with('success', "✅ \"{$listing->title}\" has been approved and is now live. The seller has been notified.");
    }

    /**
     * Reject a listing with a required reason.
     * Route: PATCH /admin/listings/{listing}/reject
     */
    public function reject(\App\Http\Requests\Admin\RejectAdRequest $request, Listing $listing): RedirectResponse
    {
        $validated = $request->validated();

        $listing->update([
            'status'           => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_at'      => null,
            'approved_by'      => auth()->id(),
        ]);

        // Notify the seller — safely handle deleted seller accounts
        if ($seller = $listing->user) {
            try {
                $seller->notify(new AdRejectedNotification($listing, $validated['rejection_reason']));
            } catch (\Throwable $e) {
                Log::warning("Could not send AdRejectedNotification for listing #{$listing->id}: " . $e->getMessage());
            }
        }

        Log::info("Admin #{auth()->id()} rejected listing #{$listing->id} \"{$listing->title}\". Reason: {$validated['rejection_reason']}");

        return back()->with('success', "❌ \"{$listing->title}\" has been rejected. The seller has been notified with the reason.");
    }

    /**
     * Delete a listing (admin override — any listing).
     * Route: DELETE /admin/listings/{listing}
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        if ($listing->image_path && ! str_starts_with($listing->image_path, 'http')) {
            Storage::disk('public')->delete($listing->image_path);
        }

        $title = $listing->title;
        $listing->delete();

        Log::info("Admin #{auth()->id()} deleted listing \"{$title}\".");

        return redirect()->route('admin.listings.index')
            ->with('success', "Listing \"{$title}\" deleted.");
    }
}

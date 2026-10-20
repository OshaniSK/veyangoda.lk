<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectAdRequest;
use App\Models\Listing;
use App\Notifications\AdApprovedNotification;
use App\Notifications\AdRejectedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdApprovalController extends Controller
{
    /**
     * Display a paginated list of pending ads for review.
     * Route: GET /admin/ads/pending
     */
    public function index(Request $request): View
    {
        $query = Listing::with(['user', 'category', 'photos'])
            ->pending()
            ->latest();

        if ($search = trim((string) $request->query('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->query('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $listings     = $query->paginate(15)->withQueryString();
        $pendingCount = Listing::pending()->count();

        return view('admin.ads.pending', compact('listings', 'pendingCount'));
    }

    /**
     * Approve a pending ad (set status = active, stamp timestamp and admin ID).
     * Dispatches AdApprovedNotification to the seller via mail + database channels.
     * Route: PATCH /admin/ads/{id}/approve
     */
    public function approve(int|string $id): RedirectResponse
    {
        $listing = Listing::with('user')->findOrFail($id);

        $listing->update([
            'status'           => 'active',
            'approved_at'      => now(),
            'approved_by'      => auth()->id(),
            'rejection_reason' => null,
        ]);

        // Dispatch queued notification to the seller if seller account still exists
        if ($seller = $listing->user) {
            try {
                $seller->notify(new AdApprovedNotification($listing));
            } catch (\Throwable $e) {
                Log::warning("Could not dispatch AdApprovedNotification for ad #{$listing->id}: {$e->getMessage()}");
            }
        }

        Log::info("Admin #" . auth()->id() . " (" . auth()->user()->email . ") approved ad #{$listing->id} [{$listing->title}].");

        return back()->with('success', "Advertisement \"{$listing->title}\" has been approved and is now live!");
    }

    /**
     * Reject a pending ad with a required reason.
     * Dispatches AdRejectedNotification to the seller via mail + database channels.
     * Route: PATCH /admin/ads/{id}/reject
     */
    public function reject(RejectAdRequest $request, int|string $id): RedirectResponse
    {
        $listing = Listing::with('user')->findOrFail($id);
        $reason  = $request->validated('rejection_reason');

        $listing->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
            'approved_at'      => null,
            'approved_by'      => auth()->id(),
        ]);

        // Dispatch queued notification with reason to the seller
        if ($seller = $listing->user) {
            try {
                $seller->notify(new AdRejectedNotification($listing, $reason));
            } catch (\Throwable $e) {
                Log::warning("Could not dispatch AdRejectedNotification for ad #{$listing->id}: {$e->getMessage()}");
            }
        }

        Log::info("Admin #" . auth()->id() . " (" . auth()->user()->email . ") rejected ad #{$listing->id} [{$listing->title}]. Reason: {$reason}");

        return back()->with('success', "Advertisement \"{$listing->title}\" has been rejected and the seller has been notified.");
    }
}

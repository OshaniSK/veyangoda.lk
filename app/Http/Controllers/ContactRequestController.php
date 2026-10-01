<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
    /**
     * Record a contact attempt (call / whatsapp / message).
     * Called via fetch() from the contact modal.
     * Route: POST /contact-requests
     */
    public function store(Request $request): JsonResponse
    {
        // Must be authenticated
        if (! auth()->check()) {
            return response()->json(['redirect' => route('login')], 401);
        }

        $validated = $request->validate([
            'listing_id' => ['required', 'exists:listings,id'],
            'type'       => ['required', 'in:call,whatsapp,message'],
            'message'    => ['nullable', 'string', 'max:1000'],
        ]);

        $listing = Listing::findOrFail($validated['listing_id']);

        // Prevent buyers from contacting themselves
        if ($listing->user_id === auth()->id()) {
            return response()->json(['error' => 'Cannot contact your own listing.'], 422);
        }

        ContactRequest::create([
            'listing_id' => $listing->id,
            'buyer_id'   => auth()->id(),
            'seller_id'  => $listing->user_id,
            'type'       => $validated['type'],
            'message'    => $validated['message'] ?? null,
        ]);

        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerController extends Controller
{
    /**
     * Display the seller's profile and their active listings.
     */
    public function show($slug): View
    {
        $seller = User::where('slug', $slug)
            ->withCount('followers')
            ->firstOrFail();

        $listings = $seller->listings()
            ->with(['category', 'photos'])
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        return view('sellers.show', compact('seller', 'listings'));
    }
}

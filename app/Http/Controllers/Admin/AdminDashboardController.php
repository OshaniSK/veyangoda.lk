<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Contracts\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Route: GET /admin
     */
    public function index(): View
    {
        $stats = [
            'total_users'    => User::count(),
            'total_listings' => Listing::count(),
            'active_listings'=> Listing::where('status', 'active')->count(),
            'sold_listings'  => Listing::where('status', 'sold')->count(),
            'total_categories' => Category::count(),
            'new_users_today'  => User::whereDate('created_at', today())->count(),
            'new_listings_today' => Listing::whereDate('created_at', today())->count(),
        ];

        // Recent activity
        $recentListings = Listing::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentListings', 'recentUsers'));
    }
}

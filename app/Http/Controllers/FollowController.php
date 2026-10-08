<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class FollowController extends Controller
{
    /**
     * Show the authenticated user's followed sellers.
     */
    public function index()
    {
        $followings = auth()->user()->followings()
            ->withCount('followers')
            ->paginate(12);

        return view('followers.index', compact('followings'));
    }

    /**
     * Toggle follow/unfollow for a seller.
     */
    public function toggle(Request $request, $sellerId)
    {
        $user = auth()->user();

        if ($user->id == $sellerId) {
            return response()->json(['error' => 'You cannot follow yourself.'], 400);
        }

        $seller = User::findOrFail($sellerId);

        // Throttle to 50 requests per hour per user
        $key = 'follow-toggle:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 50)) {
            return response()->json(['error' => 'Too many attempts. Please try again later.'], 429);
        }
        RateLimiter::hit($key, 3600);

        $isFollowing = $user->isFollowing($sellerId);

        if ($isFollowing) {
            $user->followings()->detach($sellerId);
            $following = false;
        } else {
            $user->followings()->attach($sellerId);
            $following = true;
        }

        return response()->json([
            'success' => true,
            'is_following' => $following,
            'follower_count' => $seller->followers()->count()
        ]);
    }

    /**
     * Explicitly unfollow a seller.
     */
    public function destroy($sellerId)
    {
        auth()->user()->followings()->detach($sellerId);

        return back()->with('success', 'You have unfollowed the seller.');
    }
}

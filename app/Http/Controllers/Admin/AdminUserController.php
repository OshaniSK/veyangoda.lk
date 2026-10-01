<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    /**
     * Route: GET /admin/users
     */
    public function index(): View
    {
        $users = User::withCount('listings')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Ban a user.
     * Route: PATCH /admin/users/{user}/ban
     */
    public function ban(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->with('error', 'Cannot ban an admin user.');
        }

        $user->update(['is_banned' => true]);

        return back()->with('success', '"' . $user->name . '" has been banned.');
    }

    /**
     * Unban a user.
     * Route: PATCH /admin/users/{user}/unban
     */
    public function unban(User $user): RedirectResponse
    {
        $user->update(['is_banned' => false]);

        return back()->with('success', '"' . $user->name . '" has been unbanned.');
    }

    /**
     * Delete a user and all their listings.
     * Route: DELETE /admin/users/{user}
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->with('error', 'Cannot delete an admin user.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}

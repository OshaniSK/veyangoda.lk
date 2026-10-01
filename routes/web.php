<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — CraftNest Homemade Marketplace
|--------------------------------------------------------------------------
*/

// ── Public Feed ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [HomeController::class, 'index'])->name('listings.index');

// ── Contact Us ───────────────────────────────────────────────────────────
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// ── Authenticated User Routes ─────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard redirect
    Route::get('/dashboard', fn () => redirect()->route('home'))->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post Ad (create listing)
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::get('/post-ad', [ListingController::class, 'create']);  // convenience alias
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');

    // ── My Listings ────────────────────────────────────────────────────
    Route::prefix('my-listings')->name('my-listings.')->group(function () {
        Route::get('/',              [MyListingController::class, 'index'])->name('index');
        Route::get('/{listing}/edit',[MyListingController::class, 'edit'])->name('edit');
        Route::put('/{listing}',     [MyListingController::class, 'update'])->name('update');
        Route::delete('/{listing}',  [MyListingController::class, 'destroy'])->name('destroy');
        Route::patch('/{listing}/sold', [MyListingController::class, 'markSold'])->name('sold');
    });

    // ── Messages / Inbox ───────────────────────────────────────────────
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/inbox',     [MessageController::class, 'inbox'])->name('inbox');
        Route::get('/{user}',    [MessageController::class, 'thread'])->name('thread');
        Route::post('/',         [MessageController::class, 'store'])->name('store');
    });

    // ── Contact Requests (JSON API, called from contact modal) ─────────
    Route::post('/contact-requests', [ContactRequestController::class, 'store'])
        ->name('contact-requests.store');
        
    // ── Notifications (Polling API) ────────────────────────────────────
    Route::get('/api/notifications', [App\Http\Controllers\NotificationController::class, 'index']);
    Route::post('/api/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead']);
    Route::post('/api/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
});

// ── Single Listing Show (public, wildcard after specific routes) ──────────
Route::get('/listings/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');

// ── Admin Panel ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                              [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users',                         [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/ban',            [AdminUserController::class, 'ban'])->name('users.ban');
    Route::patch('/users/{user}/unban',          [AdminUserController::class, 'unban'])->name('users.unban');
    Route::delete('/users/{user}',               [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Listings
    Route::get('/listings',                      [AdminListingController::class, 'index'])->name('listings.index');
    Route::patch('/listings/{listing}/approve',  [AdminListingController::class, 'approve'])->name('listings.approve');
    Route::patch('/listings/{listing}/reject',   [AdminListingController::class, 'reject'])->name('listings.reject');
    Route::delete('/listings/{listing}',         [AdminListingController::class, 'destroy'])->name('listings.destroy');

    // Categories
    Route::get('/categories',                    [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories',                   [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}',       [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}',      [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Contacts
    Route::get('/contacts',                      [App\Http\Controllers\ContactController::class, 'adminIndex'])->name('contacts.index');
    Route::delete('/contacts/{contact}',         [App\Http\Controllers\ContactController::class, 'destroy'])->name('contacts.destroy');
});

// ── Laravel Breeze Authentication Routes ──────────────────────────────────
require __DIR__.'/auth.php';

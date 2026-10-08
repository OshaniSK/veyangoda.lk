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
| Web Routes â€” CraftNest Homemade Marketplace
|--------------------------------------------------------------------------
*/

// â”€â”€ Public Feed â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

// â”€â”€ Contact Us â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// â”€â”€ Authenticated User Routes â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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

    // â”€â”€ My Listings â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    Route::get('/my-followed-sellers', [App\Http\Controllers\FollowController::class, 'index'])->name('followers.index');
    Route::post('/follow/{sellerId}', [App\Http\Controllers\FollowController::class, 'toggle'])->name('follow.toggle');
    Route::delete('/unfollow/{sellerId}', [App\Http\Controllers\FollowController::class, 'destroy'])->name('follow.destroy');

    Route::prefix('my-listings')->name('my-listings.')->group(function () {
        Route::get('/',              [MyListingController::class, 'index'])->name('index');
        Route::get('/{listing}/edit',[MyListingController::class, 'edit'])->name('edit');
        Route::put('/{listing}',     [MyListingController::class, 'update'])->name('update');
        Route::delete('/{listing}',  [MyListingController::class, 'destroy'])->name('destroy');
        Route::patch('/{listing}/sold', [MyListingController::class, 'markSold'])->name('sold');
    });

    // â”€â”€ Messages / Inbox â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/inbox',     [MessageController::class, 'inbox'])->name('inbox');
        Route::get('/{user}',    [MessageController::class, 'thread'])->name('thread');
        Route::post('/',         [MessageController::class, 'store'])->name('store');
    });

    // â”€â”€ Contact Requests (JSON API, called from contact modal) â”€â”€â”€â”€â”€â”€â”€â”€â”€
    Route::post('/contact-requests', [ContactRequestController::class, 'store'])
        ->name('contact-requests.store');
        
    // â”€â”€ Notifications (Polling API) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    Route::get('/api/notifications', [App\Http\Controllers\NotificationController::class, 'index']);
    Route::post('/api/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead']);
    Route::post('/api/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
});

// â”€â”€ Seller Profile â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
Route::get('/categories/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

Route::get('/sellers/{slug}', [App\Http\Controllers\SellerController::class, 'show'])->name('sellers.show');

// â”€â”€ Single Listing Show (public, wildcard after specific routes) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
Route::get('/listings/{category_slug}', [ListingController::class, 'category'])->name('listings.category');
Route::get('/listings/{category_slug}/{sub_category_slug}', [ListingController::class, 'category'])->name('listings.sub_category');
Route::get('/listings/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');

// â”€â”€ Admin Panel â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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

// â”€â”€ Laravel Breeze Authentication Routes â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
require __DIR__.'/auth.php';

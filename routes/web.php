<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Staff\OrderController as StaffOrder;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('home');

// Product routes
Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::resource('products', ProductController::class)->only(['index', 'show']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth']) 
    ->name('dashboard'); 

// All authenticated routes grouped
Route::middleware('auth')->group(function () {
    
    // --- User Profile Routes ---
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    // --- Address & Contact Routes ---
    Route::resource('addresses', App\Http\Controllers\AddressController::class);
    Route::resource('contacts', App\Http\Controllers\ContactController::class);

    // --- CART ROUTES ---
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('add', [CartController::class, 'add'])->name('add');
        Route::patch('update/{itemId}', [CartController::class, 'update'])->name('update');
        Route::delete('remove/{itemId}', [CartController::class, 'remove'])->name('remove');
        Route::post('clear', [CartController::class, 'clear'])->name('clear');
        Route::get('count', [CartController::class, 'count'])->name('count');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Management Resources
    Route::resource('products', App\Http\Controllers\ProductController::class)->except(['index', 'show']);
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('banners', App\Http\Controllers\BannerController::class);
    Route::resource('news', App\Http\Controllers\NewsController::class);
    Route::resource('vouchers', App\Http\Controllers\VoucherController::class);
    Route::resource('faqs', App\Http\Controllers\FaqController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
});

/*
|--------------------------------------------------------------------------
| Staff Routes (Admin & Staff)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::resource('orders', App\Http\Controllers\OrderController::class);
    Route::resource('order-items', App\Http\Controllers\OrderItemController::class);
    Route::resource('reviews', App\Http\Controllers\ReviewController::class);
    Route::resource('comments', App\Http\Controllers\CommentController::class);
});

require __DIR__.'/auth.php';
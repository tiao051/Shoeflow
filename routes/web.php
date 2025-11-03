<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ShoeController as AdminShoeController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Shoe Routes
Route::get('/shoes', [ShoeController::class, 'index'])->name('shoes.index');
Route::get('/shoes/{slug}', [ShoeController::class, 'show'])->name('shoes.show');
Route::get('/category/{slug}', [ShoeController::class, 'category'])->name('category.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{key}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/apply-promotion', [CheckoutController::class, 'applyPromotion'])->name('checkout.apply-promotion');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/success/{orderNumber}', [CheckoutController::class, 'success'])->name('order.success');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{orderNumber}', [ProfileController::class, 'orderDetail'])->name('profile.order-detail');
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/profile/addresses', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::delete('/profile/addresses/{id}', [ProfileController::class, 'deleteAddress'])->name('profile.addresses.delete');
    Route::get('/profile/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');
    Route::post('/profile/reviews', [ProfileController::class, 'storeReview'])->name('profile.reviews.store');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories Management
    Route::resource('categories', AdminCategoryController::class);
    
    // Shoes Management
    Route::resource('shoes', AdminShoeController::class);
    
    // Orders Management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{id}/payment', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.update-payment');
    
    // Promotions Management
    Route::resource('promotions', PromotionController::class);
    
    // Banners Management
    Route::resource('banners', BannerController::class);
});

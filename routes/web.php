<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FitsController;
use App\Http\Controllers\LimitedController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController; 
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\VoucherController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/search/process', [SearchController::class, 'process'])->name('search.process');
Route::get('/run-star-trainer', [ProductController::class, 'runStarTrainer'])->name('products.run-star-trainer');
Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/sale', [ProductController::class, 'saleProducts'])->name('products.sale');
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::get('/fits', [FitsController::class, 'index'])->name('fits.index');
Route::get('/limited-edition', [LimitedController::class, 'index'])->name('limited.index');
Route::get('/store-locator', [App\Http\Controllers\StoreController::class, 'index'])->name('stores.index');

// Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password/send', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email');
Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showCodeForm'])->name('password.code.verify');
Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verifyCode'])->name('password.code.check');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.update');

/*
|--------------------------------------------------------------------------
| Socialite Routes (Google Login)
|--------------------------------------------------------------------------
*/

Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);


/*
|--------------------------------------------------------------------------
| Verification Routes (Public Access to send code)
|--------------------------------------------------------------------------
*/

Route::post('/send-verification-code', [VerificationController::class, 'sendCode'])
    ->name('verification.send.code')
    ->withoutMiddleware([
        \App\Http\Middleware\VerifyCsrfToken::class,
    ]);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::get('/profile/orders/{id}', [ProfileController::class, 'getOrderDetails'])->name('profile.orders.details');
    
    // Address
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::patch('/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.default');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

    // Cart & Checkout
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('add', [CartController::class, 'add'])->name('add');
        Route::patch('update/{itemId}', [CartController::class, 'update'])->name('update');
        Route::delete('remove/{itemId}', [CartController::class, 'remove'])->name('remove');
        Route::post('clear', [CartController::class, 'clear'])->name('clear');
        Route::get('count', [CartController::class, 'count'])->name('count');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('check-coupon', [CartController::class, 'checkCoupon'])->name('check-coupon');
        Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process'); 
    });

    Route::get('/checkout/success/{order}', [CartController::class, 'success'])->name('checkout.success');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/checkout/vnpay-return', [CartController::class, 'vnpayReturn'])->name('vnpay.return');

    // Email Verification (Form & Verify Logic)
    Route::get('/verify-code-form', [VerificationController::class, 'showVerificationForm'])->name('verification.form');
    Route::post('/verify-code', [VerificationController::class, 'verifyCode'])->name('verification.verify');

    // Chat msgs
    Route::get('/chat/messages', [ChatController::class, 'fetchMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::middleware(['auth', 'admin'])->name('admin.')->group(function () {
        
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard'); 
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('products', AdminProductController::class);
        Route::get('orders/export', [AdminOrderController::class, 'export'])->name('orders.export');
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('brands', BrandController::class);
        Route::resource('customers', CustomerController::class)->only(['index', 'show', 'update']);

        // Chat Admin
        Route::get('/chat', [ChatController::class, 'adminIndex'])->name('chat');
        Route::get('/chat/conversations', [ChatController::class, 'adminConversations']);
        Route::get('/chat/messages/{userId}', [ChatController::class, 'adminFetchMessages']);
        Route::post('/chat/send', [ChatController::class, 'sendMessage']);
        Route::post('/chat/read', [ChatController::class, 'markAsRead']); 
        // Vouchers
        Route::resource('vouchers', VoucherController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    // Route::resource('orders', StaffOrder::class);
    // Route::resource('order-items', OrderItemController::class);
    // Route::resource('reviews', ReviewController::class);
    // Route::resource('comments', CommentController::class);
});

require __DIR__.'/auth.php';
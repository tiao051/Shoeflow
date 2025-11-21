<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard; // Giả định có Admin Dashboard Controller
use App\Http\Controllers\Staff\OrderController as StaffOrder; // Giả định có Staff Order Controller

/*
|--------------------------------------------------------------------------
| Public Routes (Routes Công khai)
|--------------------------------------------------------------------------
| Bất kỳ ai cũng có thể truy cập.
*/
Route::get('/', function () {
    return view('welcome'); // Trang chủ
});

/*
|--------------------------------------------------------------------------
| General Authenticated Routes (Routes chung cho người dùng đã đăng nhập)
|--------------------------------------------------------------------------
| Sử dụng middleware 'auth' và 'verified' (nếu cần).
*/
// Dashboard chung (truy cập được bởi mọi người dùng đã đăng nhập và xác minh)
Route::get('/dashboard', function () {
    // Tùy theo logic, bạn có thể redirect ở đây nếu là admin/staff
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (Dành cho mọi người dùng đã đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Chỉ Admin)
|--------------------------------------------------------------------------
| Cần đăng nhập và có vai trò 'admin'.
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // URL: /admin/dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Quản lý sản phẩm, danh mục, banner, news, voucher, user, v.v.
    Route::resource('products', App\Http\Controllers\ProductController::class);
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
| Cần đăng nhập và có vai trò 'admin' HOẶC 'staff'.
*/

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    // Quản lý đơn hàng, đánh giá, bình luận
    Route::resource('orders', App\Http\Controllers\OrderController::class);
    Route::resource('order-items', App\Http\Controllers\OrderItemController::class);
    Route::resource('reviews', App\Http\Controllers\ReviewController::class);
    Route::resource('comments', App\Http\Controllers\CommentController::class);
});

// Các route cho user đã đăng nhập (profile, địa chỉ, liên hệ)
Route::middleware(['auth'])->group(function () {
    Route::resource('addresses', App\Http\Controllers\AddressController::class);
    Route::resource('contacts', App\Http\Controllers\ContactController::class);
});


require __DIR__.'/auth.php'; // Các routes đăng ký, đăng nhập, quên mật khẩu
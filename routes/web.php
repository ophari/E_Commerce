<?php

use Illuminate\Support\Facades\Route;

// ==== CONTROLLERS ====
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ReviewController;

// ======================================
// GUEST, AUTH & REDIRECTION
// ======================================

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// ======================================
// ADMIN ROUTES
// ======================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin', 'no-cache'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', AdminProductController::class);
    Route::delete('products', [AdminProductController::class, 'bulkDestroy'])->name('products.bulkDestroy');

    // Brand
    Route::resource('brand', BrandController::class);

    // Orders
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store', 'edit', 'update']);

    // Customers
    Route::resource('customers', CustomerController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

    // reviews
    Route::resource('reviews', UserController::class);

});

// ======================================
// USER ROUTES
// ======================================
Route::prefix('user')->name('user.')->middleware(['auth', 'user', 'no-cache'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Products
    Route::resource('products', ProductController::class)->only(['index', 'show']);

    // Cart
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');

    // Checkout & Order
    Route::get('checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('order/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    // Review
    Route::post('review/{productId}', [ReviewController::class, 'store'])->name('review.store');

    // Profil
    Route::get('profile', fn() => view('user.pages.profile'))->name('profile');
});

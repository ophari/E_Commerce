<?php

use Illuminate\Support\Facades\Route;

// ==== AUTH & USER ====
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProfileController;

// ==== ADMIN ====
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\BrandController;


// ======================================
// ROUTE AWAL / LOGIN
// ======================================
 Route::get('/', [HomeController::class, 'index'])->name('home');

 // Produk
Route::get('/products', [ProductController::class, 'index'])->name('product.list');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.detail');


// ==== AUTH ====
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/firebase/login', [AuthController::class, 'firebaseLogin'])->name('firebase.login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::patch('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
    });

    // Customers
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('{customer}', [CustomerController::class, 'show'])->name('show');

        // Bulk actions
        Route::post('/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('bulk.delete');
        Route::post('/bulk-export', [CustomerController::class, 'bulkExport'])->name('bulk.export');

        // Export all
        Route::get('/export/csv', [CustomerController::class, 'exportCsv'])->name('export.csv');
    });

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [AdminReviewController::class, 'index'])->name('index');
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// ======================================
// USER ROUTES
// ======================================
Route::prefix('user')->name('user.')->middleware(['auth', 'user', 'no-cache'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

    // Checkout & Order
    Route::match(['GET', 'POST'], '/checkout/{productId?}', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/order/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    // Review
    Route::post('/review/{productId}', [ReviewController::class, 'store'])->name('review.store');

    // Profil
    Route::get('/profile', fn() => view('user.profile.edit'))->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});

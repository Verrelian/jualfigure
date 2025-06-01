<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ListProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerProfileController;

// Product Management Routes for Seller
Route::prefix('seller')->group(function () {
    Route::get('/product', [ListProdukController::class, 'show'])->name('seller.product');
    Route::post('/product', [ListProdukController::class, 'store'])->name('product.store');
    Route::put('/product/{id}', [ListProdukController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ListProdukController::class, 'destroy'])->name('product.destroy');
    Route::get('/product/{id}/specification', [ListProdukController::class, 'getSpecification'])->name('product.specification');
});

Route::get('/login', function () {
    return view('pages.general.login');
})->name('login');

Route::get('/register', function () {
    return view('register');
});

Route::get('/forgot_password', function () {
    return view('forgot_password');
});

Route::get('/webs', function () {
    return view('welcome');
});

// ----------------------------
// Dashboard & Seller Routes
// ----------------------------

Route::get('/dashboard', function () {
    return view('pages.general.dashboard');
})->name('dashboard');

Route::get('/home', function () {
    return view('pages.dashboard');
});

Route::get('seller/dashboardp', function () {
    return view('pages.seller.dashboardp');
})->name('dashboardp');

Route::get('seller/order', function () {
    return view('pages.seller.order');
})->name('order');

Route::get('seller/laporan', function () {
    return view('pages.seller.laporan');
})->name('laporan');

Route::get('seller/dashboard', [CrudController::class, 'index'])->name('crud.index');

Route::get('/seller/dashboard', function () {
    return view('pages.seller.dashboard');
});

Route::get('seller/dashboardp', function () {
    return view('pages.seller.dashboardp');
})->name('dashboardp');

Route::get('/mole/seller/profile', function () {
    return view('pages.seller.profile');
})->name('seller.profile');

Route::get('/seller/edit_profile', [SellerProfileController::class, 'edit'])->name('seller.edit_profile');
Route::post('/seller/profile/update', [SellerProfileController::class, 'updateProfile'])->name('seller.profile.update');
Route::get('/seller/posts', [SellerProfileController::class, 'posts'])->name('seller.posts');
Route::get('/seller/toys', [SellerProfileController::class, 'toys'])->name('seller.toys');

// ----------------------------
// Product & Wishlist
// ----------------------------

Route::get('/products', function () {
    return view('pages.products');
});

Route::get('/products/by-category', [ProductController::class, 'getProductsByCategory'])->name('products.by-category');

Route::get('/product-detail', function () {
    return view('pages.product-detail');
});

Route::get('/wishlist', function () {
    return view('pages.product.wishlist');
})->name('wishlist');

Route::get('/contact-us', function () {
    return view('pages.general.contact-us');
})->name('contact-us');

Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/ambabot', function () {
    return view('pages.general.ambabot');
})->name('ambabot');

Route::get('/product-detail', [ProductController::class, 'index'])->name('home');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

Route::get('/seller/dashboard', [DashboardController::class, 'index'])->name('seller.dashboard');


// ----------------------------
// Orders
// ----------------------------

Route::get('/detail', function () {
    return view('pages.order-detail');
});

Route::get('/order-detail', function () {
    return view('pages.order-detail');
});

Route::get('/order-status/{id?}', [OrderController::class, 'status'])->name('order.status');

Route::get('/order-history/{id?}', [OrderController::class, 'history'])->name('order.history');

// ----------------------------
// Profile
// ----------------------------

Route::get('/user/profile', [ProfileController::class, 'show'])->name('user.profile');

Route::get('/user/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');

Route::post('/user/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// ----------------------------
// Extra Pages
// ---------------------------
Route::get('/explore', [ProductController::class, 'explore'])->name('explore');

Route::get('/leaderboard', function () {
    return view('pages.general.leaderboard');
});

// Route untuk halaman postingan pengguna
Route::get('/user/posts', function () {
    return view('pages.user.user_posts');
})->name('user.posts');

// Route untuk halaman mainan yang dibeli pengguna
Route::get('/user/toys', function () {
    return view('pages.user.user_toys');
})->name('user.toys');

// Untuk menampilkan daftar post
Route::get('/feed', [PostController::class, 'index'])->name('posts.index');

// Untuk menampilkan form create
Route::get('/posts', [PostController::class, 'create'])->name('posts.create');

// Untuk menyimpan post baru
Route::post('/feed', [PostController::class, 'store'])->name('posts.store');

Route::post('/feed/{post}/like', [PostController::class, 'like'])->name('posts.like');

Route::post('/feed/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');

Route::get('/login', function () {
    return view('pages.general.login');
})->name('login');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');


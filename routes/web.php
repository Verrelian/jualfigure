<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ListProdukController;

// Product Management Routes for Seller
Route::prefix('seller')->group(function () {
    Route::get('/product', [ListProdukController::class, 'show'])->name('seller.product');
    Route::post('/product', [ListProdukController::class, 'store'])->name('product.store');
    Route::put('/product/{id}', [ListProdukController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ListProdukController::class, 'destroy'])->name('product.destroy');
    Route::get('/product/{id}/specification', [ListProdukController::class, 'getSpecification'])->name('product.specification');
});

Route::get('/login', function () {
    return view('pages.login');
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
    return view('pages.dashboard');
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

Route::get('seller/crud', [CrudController::class, 'index'])->name('crud.index');

Route::get('/seller/crud', function () {
    return view('pages.seller.crud');
});

// ----------------------------
// Product & Wishlist
// ----------------------------

Route::get('/products', function () {
    return view('pages.products');
});

Route::get('/product-detail', function () {
    return view('pages.product-detail');
});

Route::get('/wishlist', function () {
    return view('pages.wishlist');
})->name('wishlist');

Route::get('/contact-us', function () {
    return view('pages.contact-us');
})->name('contact-us');

Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/ambabot', function () {
    return view('pages.ambabot');
})->name('ambabot');

Route::get('/product-detail', [ProductController::class, 'index'])->name('home');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

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

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('profile', function () {
    return view('profile');
});

// ----------------------------
// Extra Pages
// ----------------------------

Route::get('/explore', function () {
    return view('pages.explore');
})->name('explore');

Route::get('/leaderboard', function () {
    return view('pages.leaderboard');
});

// Route untuk halaman postingan pengguna
Route::get('/user/posts', function () {
    return view('user-posts');
})->name('user.posts');

// Route untuk halaman mainan yang dibeli pengguna
Route::get('/user/toys', function () {
    return view('user-toys');
})->name('user.toys');

// Untuk menampilkan daftar post
Route::get('/feed', [PostController::class, 'index'])->name('posts.index');

// Untuk menampilkan form create
Route::get('/posts', [PostController::class, 'create'])->name('posts.create');

// Untuk menyimpan post baru
Route::post('/feed', [PostController::class, 'store'])->name('posts.store');

Route::post('/feed/{post}/like', [PostController::class, 'like'])->name('posts.like');

Route::post('/feed/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
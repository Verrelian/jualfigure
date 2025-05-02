<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\OrderController;

Route::get('seller/crud', [CrudController::class, 'index'])->name('crud.index');
Route::get('/login', function () {
    return view('pages.login');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('seller/dashboardp', function () {
    return view('pages.seller.dashboardp');
})->name('dashboardp');

Route::get('seller/product', function () {
    return view('pages.seller.product');
})->name('product');

Route::get('seller/order', function () {
    return view('pages.seller.order');
})->name('order');

Route::get('seller/laporan', function () {
    return view('pages.seller.laporan');
})->name('laporan');

Route::get('/home', function () {
    return view('pages.dashboard');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('forgot_password', function () {
    return view('forgot_password');
});

// Halaman tambahan jika diperlukan
Route::get('/webs', function () {
    return view('welcome'); // atau halaman dashboard
});

Route::get('/product-detail', function () {
    return view('pages.product-detail');
});

Route::get('/products', function () {
    return view('pages.products');
});

Route::get('/appv', function () {
    return view('pages.homev');
});

Route::get('/detail', function () {
    return view('pages.order-detail');
});

Route::get('/order-detail', function () {
    return view('pages.order-detail');
});

Route::get('/appv', function () {
    return view('pages.dashboard');
});

Route::get('/product-detail', [ProductController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');


Route::get('/wishlist', function () {
    return view('pages.wishlist');
})->name('wishlist');

Route::get('/seller/crud', function () {
    return view('pages.seller.crud');
});

Route::get('/order-status/{id?}', [OrderController::class, 'status'])->name('order.status');

Route::get('/explore', function () {
    return view('pages.explore');
});

Route::get('/leaderboard', function () {
    return view('pages.leaderboard');
});


Route::get('profile', function () {
    return view('profile');
});

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProductvController;
use App\Http\Controllers\CrudController;

Route::get('seller/crud', [CrudController::class, 'index'])->name('crud.index');
Route::get('login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('seller/dashboardp', function () {
    return view('pages.seller.dashboardp');
})->name('dashboardp');


Route::get('/home', function () {
    return view('pages.dashboard');
});

Route::get('register', function () {
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

Route::get('/produk', [ProductvController::class, 'show']);

Route::get('/detail', function () {
    return view('pages.order-detail');
});

Route::get('/order-detail', function () {
    return view('pages.order-detail');
});
Route::get('/seller/crud', function () {
    return view('pages.seller.crud');
});

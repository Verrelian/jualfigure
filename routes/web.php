<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ListProductController;

Route::get('login', function () {
    return view('login');
});

Route::get('dashboard_page', function () {
    return view('dashboard_page');
});

Route::get('product1', function () {
    return view('product1');
});

Route::get('praktikumyudik', function () {
    return view('praktikumyudik');
});

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/webs', function () {
    return view('welcome');
});

// Route ke controller kamu
Route::get('/', [ProductController::class, 'index'])->name('products.list');
Route::get('/pratikum', [ListProductController::class, 'index']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('login', function () {
    return view('login');
});

Route::get('product1', function () {
    return view('product1');
});

Route::get('praktikumyudik', function () {
  return view('praktikumyudik');

// Halaman utama profil
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

// Halaman edit profil
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// Proses update profil
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Optional: jika ada logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Halaman tambahan jika diperlukan
Route::get('/webs', function () {
    return view('welcome'); // atau halaman dashboard
});

Route::get('/', [ProductController::class, 'index'])->name('products.list'); // List Product
});

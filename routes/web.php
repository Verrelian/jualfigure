<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BerandaController;

Route::get('login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

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

Route::get('praktikumyudikk', function () {
    return view('praktikumyudik');
}); 
 

Route::get('/product-detail', function () {
    return view('pages.product-detail');
});

Route::get('/detail', function () {
    return view('pages.order-detail');
});

Route::get('/order-detail', function () {
    return view('pages.order-detail');
});

Route::get('/praktikum7', function () {
    return view('pages.praktikum7home');
});
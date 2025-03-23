<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('login', function () {
    return view('login');
});
Route::get('register', function () {
    return view('register');
});
Route::get('forgot_password', function () {
    return view('forgot_password');
});

Route::get('profil', function () {
    return view('profil');
});

Route::get('edit_profil', function () {
    return view('edit_profil');
});
Route::get('product1', function () {
    return view('product1');
});

Route::get('dashboard', function () {
    return view('dashboard');
});

Route::get('list_of_game', function () {
    return view('list_of_game');
});
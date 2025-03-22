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
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('login', function () {
    return view('login');
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
Route::get('praktikumyudik', function () {
    return view('praktikumyudik');
});

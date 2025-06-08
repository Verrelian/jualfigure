<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ProfileController,
    PostController,
    DashboardController,
    ProductController,
    CrudController,
    OrderController,
    ListProdukController,
    SellerProfileController,
    ContactController
};

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', fn() => view('register'))->name('register');
Route::get('/forgot_password', fn() => view('forgot_password'))->name('forgot_password');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome')->name('home');
Route::view('/webs', 'welcome')->name('webs');
Route::view('/contact-us', 'pages.general.contact-us')->name('contact-us');
Route::view('/ambabot', 'pages.general.ambabot')->name('ambabot');
Route::view('/leaderboard', 'pages.general.leaderboard')->name('leaderboard');

Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/
Route::get('/products', fn() => view('pages.products'))->name('products');
Route::get('/products/by-category', [ProductController::class, 'getProductsByCategory'])->name('products.by-category');
Route::get('/product-detail', [ProductController::class, 'index'])->name('product-detail');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/explore', [ProductController::class, 'explore'])->name('explore');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile
    Route::prefix('user')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::view('/posts', 'pages.user.user_posts')->name('user.posts');
        Route::view('/toys', 'pages.user.user_toys')->name('user.toys');
    });

    // Wishlist
    Route::view('/wishlist', 'pages.product.wishlist')->name('wishlist');

    // Order
    Route::prefix('order')->group(function () {
        Route::view('/detail', 'pages.order-detail')->name('order.detail');
        Route::get('/status/{id?}', [OrderController::class, 'status'])->name('order.status');
        Route::get('/history/{id?}', [OrderController::class, 'history'])->name('order.history');
    });

    // Feed/Post
    Route::prefix('feed')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::post('/{post}/like', [PostController::class, 'like'])->name('posts.like');
        Route::post('/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    });
    Route::get('/posts', [PostController::class, 'create'])->name('posts.create');

    // Seller
    Route::prefix('seller')->group(function () {

        Route::get('/dashboard', [CrudController::class, 'index'])->name('seller.dashboard');
        Route::view('/dashboardp', 'pages.seller.dashboardp')->name('seller.dashboardp');

        Route::view('/profile', 'pages.seller.profile')->name('seller.profile');
        Route::get('/edit_profile', [SellerProfileController::class, 'edit'])->name('seller.edit_profile');
        Route::post('/profile/update', [SellerProfileController::class, 'updateProfile'])->name('update');
        Route::get('/posts', [SellerProfileController::class, 'posts'])->name('seller.posts');
        Route::get('/toys', [SellerProfileController::class, 'toys'])->name('seller.toys');

        Route::prefix('product')->group(function () {
            Route::get('/', [ListProdukController::class, 'show'])->name('seller.product');
            Route::post('/', [ListProdukController::class, 'store'])->name('product.store');
            Route::put('/{id}', [ListProdukController::class, 'update'])->name('product.update');
            Route::delete('/{id}', [ListProdukController::class, 'destroy'])->name('product.destroy');
            Route::get('/{id}/specification', [ListProdukController::class, 'getSpecification'])->name('product.specification');
        });

        Route::view('/order', 'pages.seller.order')->name('seller.order');
        Route::view('/laporan', 'pages.seller.laporan')->name('seller.laporan');
    });
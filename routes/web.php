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
    ContactController,
    CheckoutController,
    PaymentController
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
Route::middleware(['auth'])->group(function () {

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
    Route::prefix('seller')->middleware(['seller'])->group(function () {

        Route::get('/dashboard', [CrudController::class, 'index'])->name('seller.dashboard');
        Route::view('/dashboardp', 'pages.seller.dashboardp')->name('seller.dashboardp');

        Route::view('/profile', 'pages.seller.profile')->name('seller.profile');
        Route::get('/edit_profile', [SellerProfileController::class, 'edit'])->name('seller.edit_profile');
        Route::post('/profile/update', [SellerProfileController::class, 'updateProfile'])->name('update');
        Route::get('/posts', [SellerProfileController::class, 'posts'])->name('seller.posts');
        Route::get('/toys', [SellerProfileController::class, 'toys'])->name('seller.toys');

        Route::prefix('product')->group(function () {
            Route::get('/', [ListProdukController::class, 'show'])->name('seller.product');
            Route::post('/', [ListProdukController::class, 'store'])->name('seller.product.store');
            Route::put('/{id}', [ListProdukController::class, 'update'])->name('seller.product.update');
            Route::delete('/{id}', [ListProdukController::class, 'destroy'])->name('seller.product.destroy');
            Route::get('/{id}/specification', [ListProdukController::class, 'getSpecification'])->name('seller.product.specification');
        });

        Route::view('/order', 'pages.seller.order')->name('seller.order');
        Route::view('/laporan', 'pages.seller.laporan')->name('seller.laporan');
    });
});

Route::get('/order-detail', function () {
    return view('pages.order-detail');
});

Route::get('/order-status/{id?}', [OrderController::class, 'status'])->name('order.status');

Route::get('/order-history/{id?}', [OrderController::class, 'history'])->name('order.history');

Route::get('/checkout/{product_id}', [CheckoutController::class, 'showForm'])->name('checkout.form');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/payment-receipt/{payment_id}', [PaymentController::class, 'showReceipt'])->name('payment.receipt');
Route::get('/payment-receipt/{payment_id}/download', [PaymentController::class, 'downloadReceipt'])->name('payment.receipt.download');

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
// ---------------------------
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

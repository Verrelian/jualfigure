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
    PaymentController,
    BankController,
    WishlistController,
    InvoiceController,
    LeaderboardController
};

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Login/Register/Logout)
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
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome')->name('home');
Route::view('/filter', 'filter')->name('filter');
Route::view('/webs', 'welcome')->name('webs');
Route::view('/contact-us', 'pages.general.contact-us')->name('contact-us');
Route::view('/ambabot', 'pages.general.ambabot')->name('ambabot');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('/api/leaderboard', [LeaderboardController::class, 'getLeaderboardData'])->name('leaderboard.api');
Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| PRODUCT ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/products', fn() => view('pages.products'))->name('products');
Route::get('/products/by-category', [ProductController::class, 'getProductsByCategory'])->name('products.by-category');
Route::get('/product-detail', [ProductController::class, 'index'])->name('product-detail');
Route::get('/product/{product_id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/explore', [ProductController::class, 'explore'])->name('explore');
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/api/filter-options', [ProductController::class, 'getFilterOptions']);



/*
|--------------------------------------------------------------------------
| CHECKOUT & PAYMENT ROUTES (Require Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth.check'])->group(function () {
    Route::get('/checkout/{product_id}', [CheckoutController::class, 'showForm'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/payment-receipt/{payment_id}', [PaymentController::class, 'showReceipt'])->name('payment.receipt');
    Route::get('/payment-receipt/{payment_id}/download', [PaymentController::class, 'downloadReceipt'])->name('payment.receipt.download');
    // Tampilkan halaman bank (BNI, BRI, Mandiri, BCA)
    Route::get('/bank/{bank}', [BankController::class, 'showPaymentPage'])->name('bank.payment');
    // Proses validasi VA number (payment_code)
    Route::post('/bank/validate-va', [BankController::class, 'validateVA'])->name('bank.validate.va');
    // Proses pembayaran (setelah VA valid dan user klik "Pay")
    Route::post('/bank/pay', [BankController::class, 'processPayment'])->name('bank.process.payment');
});

/*
|--------------------------------------------------------------------------
| BUYER ROUTES (Protected - Buyer Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'buyer.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('user')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::view('/posts', 'pages.user.user_posts')->name('user.posts');
        Route::view('/toys', 'pages.user.user_toys')->name('user.toys');
    });

    // PINDAHKAN WISHLIST ROUTES KE SINI (bukan nested)
    Route::prefix('wishlist')->group(function() {
        Route::post('/add', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::post('/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
        Route::post('/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
        Route::get('/count', [WishlistController::class, 'count'])->name('wishlist.count');
        Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
    });



    Route::prefix('order')->group(function () {
        Route::view('/detail', 'pages.order-detail')->name('order.detail');
        Route::get('/status/{id?}', [OrderController::class, 'status'])->name('order.status');
        Route::get('/history/{id?}', [OrderController::class, 'history'])->name('order.history');
    });

    Route::prefix('feed')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::post('/{post}/like', [PostController::class, 'like'])->name('posts.like');
        Route::post('/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    });
    Route::get('/posts', [PostController::class, 'create'])->name('posts.create');
});

/*
|--------------------------------------------------------------------------
| SELLER ROUTES (Protected - Seller Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'seller.auth'])->prefix('seller')->group(function () {
    // Dashboard seller (pilih salah satu)
    Route::get('/dashboard', [ListProdukController::class, 'index'])->name('seller.dashboard');

    // Profile routes
    Route::view('/profile', 'pages.seller.profile')->name('seller.profile');
    Route::get('/edit_profile', [SellerProfileController::class, 'edit'])->name('seller.edit_profile');
    Route::post('/profile/update', [SellerProfileController::class, 'updateProfile'])->name('seller.profile.update');

    // Posts and toys
    Route::get('/posts', [SellerProfileController::class, 'posts'])->name('seller.posts');
    Route::get('/toys', [SellerProfileController::class, 'toys'])->name('seller.toys');

    // Product management
    Route::prefix('product')->group(function () {
        Route::get('/', [ListProdukController::class, 'show'])->name('seller.product');
        Route::post('/', [ListProdukController::class, 'store'])->name('seller.product.store');
        Route::put('/{product_id}', [ListProdukController::class, 'update'])->name('seller.product.update');
        Route::delete('/{product_id}', [ListProdukController::class, 'destroy'])->name('seller.product.destroy');
        Route::get('/{product_id}/specification', [ListProdukController::class, 'getSpecification'])->name('seller.product.specification');
    });

    // Orders and reports
    Route::view('/order', 'pages.seller.order')->name('seller.order');
    Route::get('/laporan', [invoiceController::class, 'index'])->name('seller.laporan');
});
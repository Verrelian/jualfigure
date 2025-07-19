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
    SellerOrderController,
    BuyerHistoryController,
    ShippingProgressController,
    InvoiceController,
    CartController,
    WebController,
    DashboardSellerController,
    SearchController,
    LeaderboardController,
    ForgotPasswordController,
    BuyerProfileController,
    FollowController,
    OTPController
};

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Login/Register/Logout)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', fn() => view('register'))->name('register');
Route::get('/forgot_password', fn() => view('forgot_password'))->name('forgot_password');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgot'])->name('forgot.submit');

Route::get('/verify-token', [ForgotPasswordController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/verify-token', [ForgotPasswordController::class, 'submitVerify'])->name('verify.submit');

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitReset'])->name('reset.submit');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/product/{product_id}', [ProductController::class, 'show'])->name('product.detail');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [WebController::class, 'index'])->name('home');
Route::view('/filter', 'filter')->name('filter');
Route::view('/webs', 'welcome')->name('webs');
Route::view('/contact-us', 'pages.general.contact-us')->name('contact-us');
Route::view('/ambabot', 'pages.general.ambabot')->name('ambabot');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('/api/leaderboard', [LeaderboardController::class, 'getLeaderboardData'])->name('leaderboard.api');
Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/products', fn() => view('pages.products'))->name('products');
Route::get('/products/by-category', [ProductController::class, 'getProductsByCategory'])->name('products.by-category');
Route::get('/product-detail', [ProductController::class, 'index'])->name('product-detail');
Route::get('/product/{product_id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/explore', [ProductController::class, 'explore'])->name('explore');
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/api/filter-options', [ProductController::class, 'getFilterOptions']);

// --- RUTE PROFIL PENGGUNA LAIN (PUBLIC) ---
// Rute ini harus di luar middleware otentikasi agar bisa diakses oleh siapa saja
// Tambahkan di routes/web.php


/*
|--------------------------------------------------------------------------
| CHECKOUT & PAYMENT ROUTES (Require Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth.check'])->group(function () {
    Route::get('/checkout/{product_id}', [CheckoutController::class, 'showForm'])->name('checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout', [CheckoutController::class, 'checkoutCart'])->name('checkout.cart');
    Route::get('/payment-receipt/{payment_id}', [PaymentController::class, 'showReceipt'])->name('payment.receipt');
    Route::get('/payment-receipt/{payment_id}/download', [PaymentController::class, 'downloadReceipt'])->name('payment.receipt.download');
    Route::get('/bank/{bank}', [BankController::class, 'showPaymentPage'])->name('bank.payment');
    Route::post('/bank/validate-va', [BankController::class, 'validateVA'])->name('bank.validate.va');
    Route::post('/bank/pay', [BankController::class, 'processPayment'])->name('bank.process.payment');
});

/*
|--------------------------------------------------------------------------
| BUYER ROUTES (Protected - Buyer Only)
|--------------------------------------------------------------------------
*/
Route::prefix('order')->group(function () {
        Route::get('/status/{id?}', [OrderController::class, 'status'])->name('order.status');
    });

Route::middleware(['web', 'buyer.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/history/{id?}', [OrderController::class, 'history'])->name('order.history');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search/result', [SearchController::class, 'result'])->name('search.result');
    Route::prefix('user')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/posts/{buyer_id?}', [ProfileController::class, 'userPosts'])->name('posts.profile');

    });
    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'showCartPage'])->name('cart.index');
        Route::get('/data', [CartController::class, 'index'])->name('cart.data');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
        Route::put('/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::get('/count', [CartController::class, 'getCount'])->name('cart.count');
        Route::get('/total', [CartController::class, 'getTotal'])->name('cart.total');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    // PINDAHKAN WISHLIST ROUTES KE SINI (bukan nested)
    Route::prefix('wishlist')->group(function () {
        Route::post('/add', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::post('/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
        Route::post('/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
        Route::get('/count', [WishlistController::class, 'count'])->name('wishlist.count');
        Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
    });

    // History
    Route::prefix('pages/history')->name('history.')->group(function () {
        Route::get('/placed', [BuyerHistoryController::class, 'placed'])->name('placed');
        Route::get('/process', [BuyerHistoryController::class, 'process'])->name('process');
        Route::get('/shipping', [BuyerHistoryController::class, 'shipping'])->name('shipping');
        Route::get('/delivered', [BuyerHistoryController::class, 'delivered'])->name('delivered');
        Route::get('/canceled', [BuyerHistoryController::class, 'canceled'])->name('canceled');
        Route::get('/completed', [BuyerHistoryController::class, 'completed'])->name('completed');
        Route::get('/placed/{payment_id}', [BuyerHistoryController::class, 'showPlaced'])->name('placed.detail');
        Route::get('/process/{payment_id}', [BuyerHistoryController::class, 'showProcess'])->name('process.detail');
        Route::get('/shipping/{payment_id}', [BuyerHistoryController::class, 'showShipping'])->name('shipping.detail');
        Route::get('/delivered/{payment_id}', [BuyerHistoryController::class, 'showDelivered'])->name('delivered.detail');
        Route::get('/canceled/{payment_id}', [BuyerHistoryController::class, 'showCanceled'])->name('canceled.detail');
        Route::get('/completed/{payment_id}', [BuyerHistoryController::class, 'showCompleted'])->name('completed.detail');
        Route::post('/{payment_id}/done', [BuyerHistoryController::class, 'done'])->name('done');
        Route::post('/{payment_id}/rate', [BuyerHistoryController::class, 'rate'])->name('rate');
    });
    Route::get('/pages/partials/process/fetch', [BuyerHistoryController::class, 'fetchProcess'])->name('process.fetch');

    Route::get('/shipping/progress-data/{payment_id}', [ShippingProgressController::class, 'getProgress'])->name('shipping.progress');
    Route::post('/shipping/next-stage/{payment_id}', [ShippingProgressController::class, 'nextStage'])->name('shipping.nextStage');
    Route::get('/shipping/active', [ShippingProgressController::class, 'getActiveShipping']);
    Route::get('/process/auto-shipping', [ShippingProgressController::class, 'autoToShipping']);

    Route::prefix('feed')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::post('/{post}/like', [PostController::class, 'like'])->name('posts.like');

        // Comment routes
        Route::post('/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
        Route::post('/comment/{comment}/reply', [PostController::class, 'replyComment'])->name('posts.reply');
        Route::delete('/comment/{comment}', [PostController::class, 'deleteComment'])->name('posts.comment.delete');
    });
    // web.php - Bagian Profile Routes (Cleaned)

    Route::prefix('user')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/posts/{buyer_id?}', [ProfileController::class, 'userPosts'])->name('posts.profile');
    });

    // Profile routes for viewing other users (dari feed)
    Route::prefix('profile')->group(function () {
        Route::get('/{buyer}', [BuyerProfileController::class, 'show'])->name('profile.show');
        Route::post('/{buyer}/toggle-follow', [ProfileController::class, 'toggleFollow'])->name('profile.toggleFollow');

        // Post interactions in profile
        Route::post('/posts/{post}/like', [ProfileController::class, 'likePost'])->name('profile.posts.like');
        Route::post('/posts/{post}/comment', [ProfileController::class, 'commentPost'])->name('profile.posts.comment');
    });

    // Posts creation (jika belum ada)
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

});

/*
|--------------------------------------------------------------------------
| SELLER ROUTES (Protected - Seller Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'seller.auth'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [DashboardSellerController::class, 'index'])->name('seller.dashboard');

    // Profile routes
    Route::get('/profile', [SellerProfileController::class, 'show'])->name('seller.profile');
    Route::get('/edit_profile', [SellerProfileController::class, 'edit'])->name('seller.edit_profile');
    Route::post('/profile/update', [SellerProfileController::class, 'updateProfile'])->name('seller.profile.update');
    // PERBAIKAN: Gunakan rute baru untuk melihat profil buyer/seller lain dari perspektif seller
    Route::get('/profile/{id}', [ProfileController::class, 'showOtherUser'])->name('seller.profile.show_other');

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
    Route::prefix('/')->name('seller.order.')->group(function () {
        Route::get('/order', [SellerOrderController::class, 'index'])->name('index');
        Route::get('/order-detail/{id}', [SellerOrderController::class, 'fetch'])->name('fetch');
        Route::post('/order/{id}/process', [SellerOrderController::class, 'process'])->name('process');
        Route::post('/order/{id}/cancel', [SellerOrderController::class, 'cancel'])->name('cancel');
        Route::get('/order/{id}', [SellerOrderController::class, 'show'])->name('show');
    });

    Route::post('/to-shipping/{payment_id}', [ShippingProgressController::class, 'ToShipping'])->name('shipping.check');
    Route::view('/laporan', 'pages.seller.laporan')->name('seller.laporan');
        Route::get('/laporan', [InvoiceController::class, 'index'])->name('seller.laporan');

});

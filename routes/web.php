<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CarouselController;
use App\Http\Controllers\admin\DealController;
use App\Http\Controllers\admin\FileController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ReductionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\pages\CartController;
use App\Http\Controllers\pages\SiteController;
use App\Models\Carousel;
use App\Models\File;

//Route::get('/site', [SiteController::class, 'index'])->name('sites-home');

// Page d’accueil
Route::get('/', [SiteController::class, 'index'])->name('site.index');

// Shop
Route::get('/categories', [SiteController::class, 'categories'])->name('site.categories');
Route::get('/category', [SiteController::class, 'category'])->name('site.category');
Route::get('/product/{product_id}', [SiteController::class, 'product'])->name('site.product');
Route::get('/checkout', [SiteController::class, 'checkout'])->name('site.checkout');
Route::get('/cart', [SiteController::class, 'cart'])->name('site.cart');
Route::get('/confirmation', [SiteController::class, 'confirmation'])->name('site.confirmation');

// Blog
// Route::get('/blog', [SiteController::class, 'blog'])->name('site.blog');
// Route::get('/single-blog', [SiteController::class, 'singleBlog'])->name('site.single-blog');

// Pages
// Route::get('/login', [SiteController::class, 'login'])->name('site.login');
// Route::get('/tracking', [SiteController::class, 'tracking'])->name('site.tracking');
// Route::get('/elements', [SiteController::class, 'elements'])->name('site.elements');

// Contact
Route::get('/contact', [SiteController::class, 'contact'])->name('site.contact');
Route::post('/send-mail', [SiteController::class, 'sendMail'])->name('site.mail.post');

Route::post('/send-or-maj', [SiteController::class, 'sendOrMaj'])->name('site.send-or-maj');

Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');



// // 🔐 Authentification
// Route::prefix('admin/auth')->name('admin.auth.')->group(function () {
//     Route::get('login', [LoginBasic::class, 'index'])->name('login');
//     Route::get('register', [RegisterBasic::class, 'index'])->name('register');
// });



// // 🌐 Locale
// Route::get('/lang/{locale}', [LanguageController::class, 'swap'])->name('lang-swap');
// Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('misc-error');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [HomePage::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        // 🏠 Pages principales
        Route::get('/', [HomePage::class, 'index'])->name('pages-home');
        Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

        // 📂 Routes CRUD
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('products', ProductController::class)->names('products');
        Route::resource('reductions', ReductionController::class)->names('reductions');
        Route::resource('carousels', CarouselController::class)->names('carousels');
        Route::resource('deals', DealController::class)->names('deals');
        Route::resource('files', FileController::class)->names('files');
    });

});

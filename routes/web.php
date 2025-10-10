<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CarouselController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\PromoCodeController;
use App\Http\Controllers\admin\DealController;
use App\Http\Controllers\admin\FileController;
use App\Http\Controllers\admin\NeighborhoodController;
use App\Http\Controllers\admin\NewsletterController;
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


Route::get('/faq', function () {return view('client.faq');})->name('site.faq');
Route::get('/about', function () {return view('client.about');})->name('site.about');
Route::get('/contact', function () {return view('client.contact');})->name('site.contact');

Route::get('/products', [SiteController::class, 'categories'])->name('site.products');
Route::get('/product/{product_id}', [SiteController::class, 'product'])->name('site.product');


// Shop
Route::get('/cart', [CartController::class, 'index'])->name('site.cart');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/send-or-maj', [CartController::class, 'sendOrMaj'])->name('site.send-or-maj');
Route::post('/send-mail', [CartController::class, 'sendMail'])->name('site.mail.post');



Route::post('/newsletter/subscribe', [SiteController::class, 'storeEmail'])->name('newsletter.subscribe');


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
    // Route::get('/dashboard', [HomePage::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        // 🏠 Pages principales
        Route::get('/', [HomePage::class, 'index'])->name('pages-home');
        Route::get('/', [HomePage::class, 'index'])->name('index');
        // 📂 Routes CRUD
        Route::resource('categories', CategoryController::class)->names('categories');
        Route::resource('products', ProductController::class)->names('products');
        Route::resource('reductions', ReductionController::class)->names('reductions');
        Route::resource('carousels', CarouselController::class)->names('carousels');
        Route::resource('deals', DealController::class)->names('deals');
        Route::resource('files', FileController::class)->names('files');

        Route::resource('promo-codes', PromoCodeController::class)->except(['show'])->names('codes');
        Route::resource('cities', CityController::class)->except(['show'])->names('cities');
        Route::resource('neighborhoods', NeighborhoodController::class)->except(['show'])->names('neighborhoods');
        
        Route::get('/newsletters', [NewsletterController::class, 'index'])->name('newsletters.index');
        Route::get('/newsletters/create', [NewsletterController::class, 'create'])->name('newsletters.create');
        Route::post('/newsletters/send', [NewsletterController::class, 'send'])->name('newsletters.send');
        Route::delete('/newsletters/{newsletter}', [NewsletterController::class, 'destroy'])->name('newsletters.destroy');
    });

});

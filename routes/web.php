<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\pages\SiteController;

//Route::get('/site', [SiteController::class, 'index'])->name('sites-home');

// Page d’accueil
Route::get('/site', [SiteController::class, 'index'])->name('site.index');

// Shop
Route::get('/site/categories', [SiteController::class, 'categories'])->name('site.categories');
Route::get('/site/category', [SiteController::class, 'category'])->name('site.category');
Route::get('/site/single-product', [SiteController::class, 'singleProduct'])->name('site.single-product');
Route::get('/site/checkout', [SiteController::class, 'checkout'])->name('site.checkout');
Route::get('/site/cart', [SiteController::class, 'cart'])->name('site.cart');
Route::get('/site/confirmation', [SiteController::class, 'confirmation'])->name('site.confirmation');

// Blog
Route::get('/site/blog', [SiteController::class, 'blog'])->name('site.blog');
Route::get('/site/single-blog', [SiteController::class, 'singleBlog'])->name('site.single-blog');

// Pages
Route::get('/site/login', [SiteController::class, 'login'])->name('site.login');
Route::get('/site/tracking', [SiteController::class, 'tracking'])->name('site.tracking');
Route::get('/site/elements', [SiteController::class, 'elements'])->name('site.elements');

// Contact
Route::get('/site/contact', [SiteController::class, 'contact'])->name('site.contact');






// Main Page Route
Route::get('/', [HomePage::class, 'index'])->name('pages-home');
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

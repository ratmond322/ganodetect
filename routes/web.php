<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Models\Article;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\TokenController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute utama website Ganodetect
|
*/

// === HOMEPAGE ===
// Ambil 4 artikel terbaru untuk bagian "Related Article" di landing page
Route::get('/', function () {
    $articles = Article::orderBy('published_at', 'desc')->take(4)->get();
    return view('welcome', compact('articles'));
})->name('home');

//google
Route::get('auth/google/redirect', [SocialController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// === DASHBOARD ADMIN (untuk customer yang beli) ===
Route::get('/dashboard-admin', function () {
    return view('dashboard-admin');
})->middleware(['auth'])->name('dashboard.admin');

// === TOKEN MANAGEMENT (admin only) ===
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::post('/tokens/generate', [TokenController::class, 'store'])->name('tokens.generate');
    Route::get('/tokens/list', [TokenController::class, 'index'])->name('tokens.list');
    Route::delete('/tokens/{token}', [TokenController::class, 'destroy'])->name('tokens.destroy');
});

// === PROFILE (bagian Laravel Breeze default) ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// === ARTIKEL ===
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Landing preview (Tailwind shop/landing page)
Route::get('/landing', function () {
    return view('landing');
})->name('landing');


Route::middleware(['auth','is_admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    // contoh route CRUD artikel
    Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
});

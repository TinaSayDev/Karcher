<?php

use App\Http\Controllers\Api\AboutPageController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
// Pages navigation

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');

Route::get('/blog',[PostController::class,'index']);
Route::get('/blog/{slug}', [PostController::class, 'show']);
// корневые категории
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

Route::get('/products/{slug}', [ProductController::class, 'show']);

Route::get('/search', [SearchController::class, 'index'])->name('search.index');



/**
 * Смена языка и сохранение куки
 */

Route::post('/set-locale', function(Request $request){
    $locale = $request->input('locale');
    if (!in_array($locale, ['ru','uz','en'])) {
        $locale = 'ru';
    }
    // сохраняем в cookie на 30 дней
    return Inertia::location(url()->previous())->withCookie(cookie('locale', $locale, 60*24*30));
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

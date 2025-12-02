<?php

use App\Http\Controllers\ProfileController;
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
Route::get('/about', function () {
    return Inertia::render('About'); // имя Vue-компонента
});
Route::get('/blog', function () {
    return Inertia::render('Blog'); // имя Vue-компонента
});

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

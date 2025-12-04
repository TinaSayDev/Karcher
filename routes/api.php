<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// товары
Route::get('/products/filter', [ProductController::class, 'filter']);
Route::get('/search', [ProductController::class, 'search']);
// 1 товар
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('api.products.show');

/*Route::get('/products/{slug}', [ProductController::class, 'show']);*/


// корневые категории
Route::get('/categories', [CategoryController::class, 'index']);

// дочерние категории по slug
Route::get('/categories/{slug}', [CategoryController::class, 'show']);


/* Routes for blog */

Route::get('/blog/categories', [PostController::class, 'categories']);
Route::get('/blog/posts', [PostController::class, 'index']);
Route::get('/blog/posts/{slug}', [PostController::class, 'show']);

<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products/filter', [ProductController::class, 'filter']);
Route::get('/search', [ProductController::class, 'search']);

/* Routes for blog */

Route::get('/blog/categories', [PostController::class, 'categories']);
Route::get('/blog/posts', [PostController::class, 'index']);
Route::get('/blog/posts/{slug}', [PostController::class, 'show']);

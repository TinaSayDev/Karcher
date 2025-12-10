<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// товары
Route::get('/products/filter', [ProductController::class, 'filter']);
Route::get('/search', [ProductController::class, 'search']);
// 1 товар
Route::get('/products/{slug}', [ProductController::class, 'show']);
/*
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);*/
Route::get('/categories', [CategoryController::class, 'apiIndex']); // JSON для axios
Route::get('/categories/{slug}', [CategoryController::class, 'apiShow']); // JSON для axios дочерних категорий

Route::get('/categories/{id}/products', [CategoryController::class, 'products']);


/* Routes for blog */

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);

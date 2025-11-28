<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    // Возвращает все товары с флагом is_hit = 1
    public function hits()
    {
        $products = Product::where('is_hit', 1)->get();
        return ProductResource::collection($products);
    }
}

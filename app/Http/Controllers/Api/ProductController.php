<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Возвращает все товары с флагом is_hit = 1
    public function hits()
    {
        $products = Product::where('is_hit', 1)->get();
        return ProductResource::collection($products);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $locale = app()->getLocale(); // текущая локаль ru/uz/en
        $query = $request->q;

        $products = Product::query()
            ->whereHas('translations', function($t) use ($query, $locale) {
                $t->where('locale', $locale)
                    ->where(function($sub) use ($query) {
                        $sub->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%");
                    });
            })
            ->limit(20)
            ->get();

        return ProductResource::collection($products);
    }

}

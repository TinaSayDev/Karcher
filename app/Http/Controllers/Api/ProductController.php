<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function filter(Request $request)
    {
        $flag = $request->get('filter');
        $limit = (int) $request->get('limit', 8);
        $offset = (int) $request->get('offset', 0);

        $query = Product::query();

        switch ($flag) {
            case 'hit':
                $query->where('is_hit', true)->orderByDesc('id');
                break;
            case 'new':
                $query->where('is_new', true)->orderByDesc('id');
                break;
            case 'recommended':
                $query->where('is_recommended', true)->orderByDesc('id');
                break;
            case 'sale':
                $query->where('is_sale', true)->orderByDesc('id');
                break;
            default:
                $query->orderByDesc('id');
        }

        // Берём limit + 1 для проверки, есть ли ещё
        $products = $query->skip($offset)->take($limit + 1)->get();

        $hasMore = $products->count() > $limit;

        // Возьмём ровно limit для фронта
        $products = $products->take($limit);

        return response()->json([
            'data' => ProductResource::collection($products),
            'hasMore' => $hasMore,
        ]);
    }




    public function show(Request $request, $slug)
    {
        $locale = app()->getLocale();

        $product = \App\Models\Product::whereHas('translations', fn($q) =>
        $q->where('slug', $slug)
        )
            ->with([
                'translations',
                'category.translations',
                'category.products.translations',
            ])
            ->firstOrFail();

        return Inertia::render('ProductDetail', [
            'locale' => $locale,
            'product' => [
                'id' => $product->id,
                'code' => $product->code,
                'price_old' => $product->price_old,
                'price_new' => $product->price_new,
                'image_main' => $product->image_main,
                'images' => $product->images ?? [],

                // переводы продукта
                'name' => $product->translation($locale)->name ?? '',
                'slug' => $product->translation($locale)->slug ?? '',
                'short_description' => $product->translation($locale)->short_description ?? '',
                'description' => $product->translation($locale)->description ?? '',
                'specifications' => $product->translation($locale)->specifications ?? '',
                'equipment' => $product->translation($locale)->equipment ?? '',

                // категория и связанные товары
                'category' => [
                    'id' => $product->category->id,
                    'slug' => $product->category->translation($locale)->slug ?? '',
                    'name' => $product->category->translation($locale)->name ?? '',
                    'products' => $product->category->products->map(fn($p) => [
                        'id' => $p->id,
                        'slug' => $p->translation($locale)->slug ?? '',
                        'name' => $p->translation($locale)->name ?? '',
                        'price_new' => $p->price_new,
                        'image_main' => $p->image_main,
                    ])
                ],
            ]
        ]);
    }


}

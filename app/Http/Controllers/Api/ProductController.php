<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function filter(Request $request)
    {
        $flag = $request->get('flag');   // например: hit, new, recommended, sale
        $limit = $request->get('limit'); // например 12 (необязательно)

        $query = Product::query();

        // Фильтр по флагу
        switch ($flag) {
            case 'hit':
                $query->orderByDesc('is_hit');
                break;

            case 'new':
                $query->orderByDesc('is_new');
                break;

            case 'recommended':
                $query->orderByDesc('is_recommended');
                break;

            case 'sale':
                $query->orderByDesc('is_sale');
                break;

            default:
                // Без фильтра — просто все товары со стандартной сортировкой
                $query->orderBy('id');
        }

        // Лимит, если нужен
        if ($limit) {
            $query->limit($limit);
        }

        $products = $query->get();

        return ProductResource::collection($products);
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

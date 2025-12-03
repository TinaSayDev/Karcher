<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

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




    // Поиск через поисковое поле
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $locale = app()->getLocale(); // текущая локаль ru/uz/en
        $query = $request->q;

        $products = Product::query()
            ->whereHas('translations', function ($t) use ($query, $locale) {
                $t->where('locale', $locale)
                    ->where(function ($sub) use ($query) {
                        $sub->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%");
                    });
            })
            ->limit(20)
            ->get();

        return ProductResource::collection($products);
    }

}

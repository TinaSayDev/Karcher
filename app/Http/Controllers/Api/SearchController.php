<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $locale = app()->getLocale();

        $products = Product::with(['translations'])
            ->whereHas('translations', fn($q) => $q->where('locale', $locale)
                ->where('name', 'like', "%{$query}%")
            )
            ->get()
            ->map(fn($product) => [
                'id' => $product->id,
                'name' => $product->translation($locale)?->name ?? '',
                'slug' => $product->translation($locale)?->slug ?? '',
                'price_new' => $product->price_new,
                'price_old' => $product->price_old,
                'image_main' => $product->image_main,
            ]);

        return Inertia::render('SearchResults', [
            'query' => $query,
            'products' => $products,
        ]);
    }
}

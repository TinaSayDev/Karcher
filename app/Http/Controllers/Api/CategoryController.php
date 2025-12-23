<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $categories = Category::whereNull('parent_id')
            ->with([
                'translations',
                'children.translations',
                'children.products.translations',
            ])
            ->get();

        return Inertia::render('Categories', [
            'locale' => $locale,
            'cats' => $categories->map(fn($cat) => [
                'id' => $cat->id,
                'slug' => $cat->translation()?->slug,
                'image' => $cat->image,
                'name' => $cat->translation()?->name ?? '',
                'description' => $cat->translation()?->description ?? '',
                'children' => $cat->children->map(fn($child) => [
                    'id' => $child->id,
                    'slug' => $child->translation()?->slug,
                    'image' => $child->image,
                    'name' => $child->translation()?->name ?? '',
                    'products' => $child->products->map(fn($product) => [
                        'id' => $product->id,
                        'slug' => $product->translation()?->slug,
                        'name' => $product->translation()?->name ?? '',
                        'price' => $product->price,
                        'image_main' => $product->image_main,
                    ]),
                ]),
            ]),
        ]);
    }

    public function show(Request $request, $slug)
    {
        $locale = app()->getLocale();

        $category = Category::whereHas('translations', fn ($q) =>
        $q->where('slug', $slug))
            ->with([
                'translations',
                'children.translations',
                'children.products.translations',
            ])
            ->firstOrFail();

        return Inertia::render('Categories', [
            'locale' => $locale,
            'category' => [
                'id' => $category->id,
                'slug' => $category->translation()?->slug,
                'name' => $category->translation()?->name ?? '',
                'forceGrid' => request()->boolean('grid'),
                'description' => $category->translation()?->description ?? '',
                'children' => $category->children->map(fn ($child) => [
                    'id' => $child->id,
                    'slug' => $child->translation()?->slug,
                    'image' => $child->image,
                    'name' => $child->translation()?->name ?? '',
                    'description' => $child->translation()?->description ?? '',
                    'products' => $child->products->map(fn ($product) => [
                        'id' => $product->id,
                        'slug' => $product->translation()?->slug,
                        'name' => $product->translation()?->name ?? '',
                        'price_new' => $product->price_new,
                        'price_old' => $product->price_old,
                        'image_main' => $product->image_main,
                    ]),
                ]),

                // 👇 товары самой категории
                'products' => $category->products->map(fn ($product) => [
                    'id' => $product->id,
                    'slug' => $product->translation()?->slug,
                    'name' => $product->translation()?->name ?? '',
                    'price_new' => $product->price_new,
                    'price_old' => $product->price_old,
                    'image_main' => $product->image_main,
                ]),
            ],
        ]);

    }


    public function apiChildren(Request $request, $slug)
    {
        $locale = app()->getLocale();

        // Находим категорию по slug с переводами
        $category = Category::whereHas('translations', fn($q) =>
        $q->where('slug', $slug)
        )
            ->with(['children.translations'])
            ->firstOrFail();

        // Формируем JSON с дочерними категориями
        $children = $category->children->map(fn($child) => [
            'id' => $child->id,
            'slug' => $child->translation()?->slug,
            'name' => $child->translation()?->name ?? '',
        ]);

        return response()->json($children);
    }



}

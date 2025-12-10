<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function show($slug)
    {
        $locale = app()->getLocale();

        $category = Category::whereHas('translations', fn($q) => $q->where('slug', $slug))
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
                'children' => $category->children->map(fn($child) => [
                    'id' => $child->id,
                    'slug' => $child->translation()?->slug,
                    'image' => $child->image,
                    'name' => $child->translation()?->name ?? '',
                    'products' => $child->products->map(fn($product) => [
                        'id' => $product->id,
                        'slug' => $product->translation()?->slug,
                        'name' => $product->translation()?->name ?? '',
                        'price' => $product->price_new,
                        'image_main' => $product->image_main,
                    ]),
                ]),
            ],
        ]);
    }

}

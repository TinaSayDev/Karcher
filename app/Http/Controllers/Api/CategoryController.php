<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Models\CategoryTranslation;

class CategoryController extends Controller
{
    // корневые категории
    public function index()
    {
//        $categories=Category::with('translations')->get()->map(function($c) {
//            return $c->translations->firstWhere('locale', app()->getLocale());
//        });

        $categories = Category::whereNull('parent_id')
            ->with('translations')
            ->orderBy('id')
            ->get();

        return CategoryResource::collection($categories);
    }

    // дочерние категории по slug
    public function show($slug)
    {
        $locale = app()->getLocale();

        $translation = CategoryTranslation::where('slug', $slug)
            ->where('locale', $locale)
            ->firstOrFail();

        $category = Category::with('translations', 'children.translations')
            ->findOrFail($translation->category_id);

        $children = $category->children;

        return response()->json([
            'category' => new CategoryResource($category),
            'items'    => CategoryResource::collection($children),
        ]);
    }
}

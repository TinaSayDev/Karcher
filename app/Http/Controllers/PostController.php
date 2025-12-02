<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Получить все категории блога
    public function categories()
    {
        $categories = PostCategory::all();
        return response()->json($categories);
    }

    // Получить все посты, можно фильтровать по категории
    public function index(Request $request)
    {
        $query = Post::with(['translations', 'categories']);

        if ($request->has('category')) {
            $categorySlug = $request->category;
            $query->whereHas('categories', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $posts = $query->where('is_published', true)->get();

        // Выбираем перевод по текущему языку
        $locale = app()->getLocale();
        $posts->each(function($post) use ($locale) {
            $post->translation = $post->translations->where('locale', $locale)->first();
        });

        return response()->json($posts);
    }

    // Получить один пост по slug
    public function show($slug)
    {
        $post = Post::with(['translations', 'categories'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $locale = app()->getLocale();
        $post->translation = $post->translations->where('locale', $locale)->first();

        return response()->json($post);
    }
}

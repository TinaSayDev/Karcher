<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{

    // Получить все посты, можно фильтровать по категории
    public function index(Request $request)
    {
        $posts = Post::with('translations')->get(); // подтягиваем переводы

        return Inertia::render('Blog', [
            'posts' => $posts->map(fn($post) => [
                'id' => $post->id,
                'slug' => $post->slug,
                'image' => $post->image,
                'title' => $post->translation()?->title ?? '',
                'excerpt' => $post->translation()?->excerpt ?? '',
                'content' => $post->translation()?->content ?? '',
            ]),
        ]);
    }

    /**
     * Получить один пост по slug
     */
    public function show($slug)
    {
        $locale = app()->getLocale();

        $post = Post::where('slug', $slug)
            ->with(['translations' => fn($q) => $q->where('locale', $locale)])
            ->firstOrFail();

        $translation = $post->translation($locale);

        return Inertia::render('BlogPost', [
            'post' => [
                'slug' => $post->slug,
                'image' => $post->image,
                'title' => $translation->title ?? '',
                'excerpt' => $translation->excerpt ?? '',
                'content' => $translation->content ?? '',
            ]
        ]);
    }

}

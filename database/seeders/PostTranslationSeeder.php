<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostTranslation;

class PostTranslationSeeder extends Seeder
{
    public function run()
    {
        $locales = ['ru', 'en', 'uz'];

        $posts = Post::all();

        foreach ($posts as $post) {
            foreach ($locales as $locale) {
                PostTranslation::create([
                    'post_id' => $post->id,
                    'locale' => $locale,
                    'title' => match($locale) {
                        'ru' => 'Заголовок '.$post->slug,
                        'en' => 'Title '.$post->slug,
                        'uz' => 'Sarlavha '.$post->slug,
                    },
                    'excerpt' => match($locale) {
                        'ru' => 'Краткое описание '.$post->slug,
                        'en' => 'Short excerpt '.$post->slug,
                        'uz' => 'Qisqa tavsif '.$post->slug,
                    },
                    'content' => match($locale) {
                        'ru' => 'Полный текст '.$post->slug,
                        'en' => 'Full content '.$post->slug,
                        'uz' => 'To‘liq matn '.$post->slug,
                    },
                ]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            ['slug' => 'first-post', 'image' => 'post1.jpg', 'is_published' => true],
            ['slug' => 'second-post', 'image' => 'post2.jpg', 'is_published' => true],
            ['slug' => 'third-post', 'image' => 'post3.jpg', 'is_published' => true],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}

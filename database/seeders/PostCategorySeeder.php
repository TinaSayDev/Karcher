<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Новости', 'slug' => 'news'],
            ['name' => 'Советы', 'slug' => 'tips'],
            ['name' => 'Обзоры', 'slug' => 'reviews'],
        ];

        foreach ($categories as $cat) {
            PostCategory::create($cat);
        }
    }
}

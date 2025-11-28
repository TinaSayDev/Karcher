<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vacuumCategory = Category::where('slug', 'home-garden')->first();

        $product = Product::create([
            'category_id' => $vacuumCategory->id,
            'slug' => 'karcher-kva-2',
            'price' => 450.00,
            'is_hit' => true,
            'is_recommended' => true,
            'is_new' => false,
            'is_discounted' => false,
        ]);

        $translations = [
            ['locale' => 'ru', 'name' => 'Karcher KVA 2', 'description' => 'Пылесос высокого качества.'],
            ['locale' => 'en', 'name' => 'Karcher KVA 2', 'description' => 'High quality vacuum cleaner.'],
            ['locale' => 'uz', 'name' => 'Karcher KVA 2', 'description' => 'Yuqori sifatli changyutgich.'],
        ];

        foreach ($translations as $t) {
            $product->translations()->create($t);
        }
    }
}

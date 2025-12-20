<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductParserSeeder extends Seeder
{
    public function run(): void
    {
        // --- Продукты ---
        $products = [
            [
                'name_ru' => 'Минимойка высокого давления K 2 Universal Edition Car',
                'price' => 1900000,
                'image' => 'products/K_2_Universal_Edition_Car.jpg',
            ],
            [
                'name_ru' => 'Минимойка высокого давления K 2 Premium Car',
                'price' => 2300000,
                'image' => 'products/K_2_Premium_Car.jpg',
            ],
            [
                'name_ru' => 'Минимойка высокого давления K 2 Classic',
                'price' => 1700000,
                'image' => 'products/d0_a0d51a8e-fa69-42bb-be95-d83b5286084c.jpg',
            ],
            [
                'name_ru' => 'Минимойка высокого давления K 2 Universal Edition',
                'price' => 990000,
                'image' => 'products/d0-19.jpg',
            ],
            [
                'name_ru' => 'Минимойка высокого давления K 2 Power Control',
                'price' => 2200000,
                'image' => 'products/1673400_std_1_96-dpi-jpg.jpg',
            ],
        ];

        foreach ($products as $index => $item) {
            $product = Product::create([
                'category_id' => 50, // добавляем категорию
                'price_new' => $item['price'],
                'price_old' => $item['price'],
                'image_main' => $item['image'],
            ]);

            // создаём переводы
            $this->addTranslations(
                $product,
                $item['name_ru'],   // ru
                Str::slug($item['name_ru'], ' '), // en, временно через slug + заглавные
                $item['name_ru']    // uz, временно как ru
            );
        }
    }

    private function addTranslations(Product $product, string $ru, string $en, string $uz): void
    {
        $en = ucwords($en);

        $product->translations()->createMany([
            [
                'locale' => 'en',
                'name' => $en,
                'slug' => Str::slug($en),
            ],
            [
                'locale' => 'ru',
                'name' => $ru,
                'slug' => Str::slug($ru),
            ],
            [
                'locale' => 'uz',
                'name' => $uz,
                'slug' => Str::slug($uz),
            ],
        ]);
    }
}

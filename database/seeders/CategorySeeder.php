<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // --- Главные категории ---
        $home = Category::create([
            'parent_id' => null,
            'type' => 1,
            'image' => null,
            'order' => 1,
        ]);

        $professional = Category::create([
            'parent_id' => null,
            'type' => 2,
            'image' => null,
            'order' => 2,
        ]);

        // --- Переводы ---
        $this->addTranslations($home, 'Home', 'Главная', 'Bosh sahifa');
        $this->addTranslations($professional, 'Professional', 'Профессиональная', 'Professional');

        // --- Подкатегории для Home ---
        $subcategories = [
            'Минимойки',
            'Пылесосы',
            'Пароочистители',
            'Аппараты для влажной уборки пола',
            'Стеклоочистители (пылесосы для окон)',
            'Аксессуары',
            'Насосы',
            'Полив',
            'Техника для сада',
            'Электрический скребок для удаления льда'
        ];

        foreach ($subcategories as $index => $nameRu) {
            $cat = Category::create([
                'parent_id' => $home->id,
                'type' => 1,
                'order' => $index + 1,
            ]);

            // переводы
            $nameEn = Str::slug($nameRu, ' ');
            $nameEn = ucwords($nameEn);

            $nameUz = $nameRu; // временно тот же текст, можно позже заменить

            $this->addTranslations($cat, $nameEn, $nameRu, $nameUz);
        }
    }

    private function addTranslations(Category $category, string $en, string $ru, string $uz): void
    {
        $category->translations()->createMany([
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

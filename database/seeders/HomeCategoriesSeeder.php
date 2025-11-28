<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryTranslation;

class HomeCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Находим корневую категорию "Home & Garden"
        $parent = Category::whereHas('translations', function ($q) {
            $q->where('locale', 'ru')->where('name', 'Бытовая техника');
        })->first();

        if (!$parent) {
            dump("Категория 'Бытовая техника' не найдена");
            return;
        }

        $items = [
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

        foreach ($items as $item) {
            $category = Category::create([
                'parent_id' => $parent->id,
                'type'      => $parent->type, // та же группа: бытовая техника
                'slug'      => str()->slug($item),
            ]);

            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale'      => 'ru',
                'name'        => $item,
                'description' => null,
            ]);

            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale'      => 'en',
                'name'        => $item,
                'description' => null,
            ]);

            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale'      => 'uz',
                'name'        => $item,
                'description' => null,
            ]);
        }
    }
}

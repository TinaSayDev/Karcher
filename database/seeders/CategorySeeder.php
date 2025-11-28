<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Бытовая техника
        $household = Category::create([
            'parent_id' => null,
            'type' => 1,
            'slug' => 'household',
        ]);

        $translations = [
            ['locale' => 'ru', 'name' => 'Бытовая техника', 'description' => ''],
            ['locale' => 'en', 'name' => 'Household', 'description' => ''],
            ['locale' => 'uz', 'name' => 'Maishiy texnika', 'description' => ''],
        ];

        foreach ($translations as $t) {
            $household->translations()->create($t);
        }

        // Профессиональная техника
        $professional = Category::create([
            'parent_id' => null,
            'type' => 2,
            'slug' => 'professional',
        ]);

        $translations = [
            ['locale' => 'ru', 'name' => 'Профессиональная техника', 'description' => ''],
            ['locale' => 'en', 'name' => 'Professional', 'description' => ''],
            ['locale' => 'uz', 'name' => 'Professional texnika', 'description' => ''],
        ];

        foreach ($translations as $t) {
            $professional->translations()->create($t);
        }

        // Пример вложенной категории: Home & Garden
        $homeGarden = Category::create([
            'parent_id' => $household->id,
            'type' => 1,
            'slug' => 'home-garden',
        ]);

        $translations = [
            ['locale' => 'ru', 'name' => 'Дом и сад', 'description' => ''],
            ['locale' => 'en', 'name' => 'Home & Garden', 'description' => ''],
            ['locale' => 'uz', 'name' => 'Uy va bog', 'description' => ''],
        ];

        foreach ($translations as $t) {
            $homeGarden->translations()->create($t);
        }

    }
}

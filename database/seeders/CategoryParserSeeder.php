<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryParserSeeder extends Seeder
{
    public function run()
    {
        $imagePath = public_path('images/categories');
        if (!File::exists($imagePath)) {
            File::makeDirectory($imagePath, 0755, true);
        }

        $categories = [
            'Минимойки Высокого Давления' => '//karcher.uz/cdn/shop/collections/Pressure-washers_9ed72616-fcf8-4b55-bc03-ab4a34fcd6f8.jpg?v=1717419219',
            'Пароочистители' => '//karcher.uz/cdn/shop/collections/1513280_hero_01-Web_800_Max.jpg?v=1718198676',
            'Пылесосы' => '//karcher.uz/cdn/shop/collections/1198680_hero_01-Web_800_Max.jpg?v=1718204130',
            'Оконные пылесосы' => '//karcher.uz/cdn/shop/collections/WV_Hero.jpg?v=1718211548',
            'Моющие пылесосы' => '//karcher.uz/cdn/shop/collections/1081200_hero_02-Web_800_Max.jpg?v=1718214842',
            'Электрошвабры' => '//karcher.uz/cdn/shop/collections/FC_Hero.jpg?v=1718211948',
            'Электровеники' => '//karcher.uz/cdn/shop/collections/1258010_hero_3-Web_400_Max_Qd.jpg?v=1718211640',
            'Очиститель воздуха' => '//karcher.uz/cdn/shop/collections/AF_Hero.jpg?v=1718265466',
        ];

        foreach ($categories as $name => $url) {
            $url = str_replace('//', 'https://', $url);

            $fileName = preg_replace('/[^\w\d\-]/u', '_', $name) . '.jpg';
            $filePath = $imagePath . '/' . $fileName;
            $dbPath = 'categories/' . $fileName;

            $slug = Str::slug($name, '-');

            // Скачиваем картинку
            try {
                $imageData = file_get_contents($url);
                if ($imageData) {
                    file_put_contents($filePath, $imageData);

                    // Проверяем существование по name в переводах
                    $translation = DB::table('category_translations')
                        ->where('name', $name)
                        ->where('locale', 'ru')
                        ->first();

                    if ($translation) {
                        // Обновляем категорию и перевод
                        DB::table('categories')->where('id', $translation->category_id)->update([
                            'image' => $dbPath,
                            'updated_at' => now(),
                        ]);

                        DB::table('category_translations')->where('id', $translation->id)->update([
                            'slug' => $slug,
                            'updated_at' => now(),
                        ]);

                        echo "Категория '$name' обновлена\n";
                    } else {
                        // Создаём новую категорию
                        $categoryId = DB::table('categories')->insertGetId([
                            'image' => $dbPath,
                            'parent_id'=>1, // Home and garden
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        DB::table('category_translations')->insert([
                            'category_id' => $categoryId,
                            'name' => $name,
                            'slug' => $slug,
                            'locale' => 'ru',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        echo "Категория '$name' добавлена\n";
                    }
                } else {
                    echo "Не удалось скачать $url\n";
                }
            } catch (\Exception $e) {
                echo "Ошибка при скачивании $url: " . $e->getMessage() . "\n";
            }
        }

        echo "Сидирование завершено.\n";
    }
}

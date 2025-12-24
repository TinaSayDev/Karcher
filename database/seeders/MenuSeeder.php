<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Верхний уровень
        $catalog = Menu::create([
            'title' => [
                'ru' => 'КАТАЛОГ',
                'en' => 'CATALOG',
                'uz' => 'KATALOG'
            ],
            'url' => '/categories',
            'parent_id' => null,
            'sort' => 1,
            'is_active' => true,
        ]);

        $homeGarden = Menu::create([
            'title' => [
                'ru' => 'ДЛЯ ДОМА И САДА',
                'en' => 'HOME AND GARDEN',
                'uz' => 'UY VA BOG\''
            ],
            'url' => '/categories/home-and-garden',
            'parent_id' => null,
            'sort' => 2,
            'is_active' => true,
        ]);

        $professional = Menu::create([
            'title' => [
                'ru' => 'ПРОФЕССИОНАЛЬНАЯ ТЕХНИКА',
                'en' => 'PROFESSIONAL EQUIPMENT',
                'uz' => 'PROFESSIONAL TEXNIKA'
            ],
            'url' => '/categories/professional',
            'parent_id' => null,
            'sort' => 3,
            'is_active' => true,
        ]);

        $contacts = Menu::create([
            'title' => [
                'ru' => 'ПОКУПКА И СЕРВИС',
                'en' => 'PURCHASE & SERVICE',
                'uz' => 'SOTIB OLISH VA SERVIS'
            ],
            'url' => '/contacts',
            'parent_id' => null,
            'sort' => 4,
            'is_active' => true,
        ]);

        $about = Menu::create([
            'title' => [
                'ru' => 'О КОМПАНИИ',
                'en' => 'ABOUT US',
                'uz' => 'KOMPANIYA HAQIDA'
            ],
            'url' => '/about',
            'parent_id' => null,
            'sort' => 5,
            'is_active' => true,
        ]);

        $blog = Menu::create([
            'title' => [
                'ru' => 'БЛОГ',
                'en' => 'BLOG',
                'uz' => 'BLOG'
            ],
            'url' => '/blog',
            'parent_id' => null,
            'sort' => 6,
            'is_active' => true,
        ]);

        // Подкатегории для "ДЛЯ ДОМА И САДА"
        $homeSubcategories = [
            ['ru'=>'Минимойки Высокого Давления','en'=>'High Pressure Washers','uz'=>'Yuqori bosimli yuvish','url'=>'/categories/minimoiki-vysokogo-davleniia'],
            ['ru'=>'Пароочистители','en'=>'Steam Cleaners','uz'=>'Bug\' tozalagichlar','url'=>'/categories/paroocistiteli'],
            ['ru'=>'Пылесосы','en'=>'Vacuum Cleaners','uz'=>'Changyutgichlar','url'=>'/categories/pylesosy'],
            ['ru'=>'Оконные пылесосы','en'=>'Window Vacuums','uz'=>'Oyna changyutgichlari','url'=>'/categories/okonnye-pylesosy'],
            ['ru'=>'Моющие пылесосы','en'=>'Washing Vacuums','uz'=>'Yuvuvchi changyutgichlar','url'=>'/categories/moiushhie-pylesosy'],
            ['ru'=>'Электрошвабры','en'=>'Electric Mops','uz'=>'Elektr shvabrlar','url'=>'/categories/elektrosvabry'],
            ['ru'=>'Электровеники','en'=>'Electric Brooms','uz'=>'Elektr supurgilar','url'=>'/categories/elektroveniki'],
            ['ru'=>'Очиститель воздуха','en'=>'Air Purifier','uz'=>'Havo tozalagich','url'=>'/categories/ocistitel-vozduxa'],
            ['ru'=>'Стеклоочистители','en'=>'Window Cleaners','uz'=>'Oyna tozalagichlar','url'=>'/categories/stekloochistiteli'],
        ];

        foreach ($homeSubcategories as $i => $sub) {
            Menu::create([
                'title' => ['ru'=>$sub['ru'], 'en'=>$sub['en'], 'uz'=>$sub['uz']],
                'url' => $sub['url'],
                'parent_id' => $homeGarden->id,
                'sort' => $i + 1,
                'is_active' => true,
            ]);
        }

        // Подкатегории для "ПРОФЕССИОНАЛЬНАЯ ТЕХНИКА"
        $proSubcategories = [
            ['ru'=>'Моечное оборудование','en'=>'Washing Equipment','uz'=>'Yuvish uskunalari','url'=>'/categories/professional/washing'],
            ['ru'=>'Пылесосы для профессионалов','en'=>'Professional Vacuums','uz'=>'Professional changyutgichlar','url'=>'/categories/professional/vacuums'],
            ['ru'=>'Поломоечные машины','en'=>'Floor Scrubbers','uz'=>'Pol yuvish mashinalari','url'=>'/categories/professional/floor-scrubbers'],
        ];

        foreach ($proSubcategories as $i => $sub) {
            Menu::create([
                'title' => ['ru'=>$sub['ru'], 'en'=>$sub['en'], 'uz'=>$sub['uz']],
                'url' => $sub['url'],
                'parent_id' => $professional->id,
                'sort' => $i + 1,
                'is_active' => true,
            ]);
        }
    }
}

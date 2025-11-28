<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // --- Найдём нужные категории ---
        $vacuum = Category::whereHas('translations', fn($q) =>
        $q->where('name', 'Пылесосы')
        )->first();

        $wash = Category::whereHas('translations', fn($q) =>
        $q->where('name', 'Минимойки')
        )->first();

        $steam = Category::whereHas('translations', fn($q) =>
        $q->where('name', 'Пароочистители')
        )->first();

        // -------------------------------
        // 1) Пылесос KVA 2 (пример)
        // -------------------------------
        $this->addProduct(
            category: $vacuum,
            code: '1.198-671',
            name: [
                'ru' => 'KVA 2',
                'en' => 'KVA 2 Vacuum Cleaner',
                'uz' => 'KVA 2 Changyutgich',
            ],
            description: [
                'ru' => 'Компактный и лёгкий пылесос для ежедневной уборки.',
                'en' => 'Compact and lightweight vacuum cleaner for daily cleaning.',
                'uz' => 'Kundalik tozalash uchun ixcham va yengil changyutgich.',
            ],
            price_old: null,
            price_new: null,
            images: [
                'kva2_1.jpg',
                'kva2_2.jpg',
                'kva2_3.jpg',
            ],
            specs: [
                ['Battery pack', '100 – 240 V'],
                ['Noise level', '< 78 dB'],
                ['Weight', '2.1 kg'],
                ['Charging time', '240 min'],
            ],
            equipment: [
                'HEPA filter',
                'Slot nozzle',
                'Brush attachment 2-in-1',
                'Wall mount',
            ]
        );

        $this->addProduct(
            category: $vacuum,
            code: '1.198-670',
            name: [
                'ru' => 'KVA 2',
                'en' => 'KVA 2 Vacuum Cleaner',
                'uz' => 'KVA 2 Changyutgich',
            ],
            description: [
                'ru' => 'Компактный и лёгкий пылесос для ежедневной уборки.',
                'en' => 'Compact and lightweight vacuum cleaner for daily cleaning.',
                'uz' => 'Kundalik tozalash uchun ixcham va yengil changyutgich.',
            ],
            price_old: null,
            price_new: null,
            images: [
                'kva2_1.jpg',
                'kva2_2.jpg',
                'kva2_3.jpg',
            ],
            specs: [
                ['Battery pack', '100 – 240 V'],
                ['Noise level', '< 78 dB'],
                ['Weight', '2.1 kg'],
                ['Charging time', '240 min'],
            ],
            equipment: [
                'HEPA filter',
                'Slot nozzle',
                'Brush attachment 2-in-1',
                'Wall mount',
            ]
        );


        $this->addProduct(
            category: $vacuum,
            code: '1.198-673',
            name: [
                'ru' => 'KVA 2',
                'en' => 'KVA 2 Vacuum Cleaner',
                'uz' => 'KVA 2 Changyutgich',
            ],
            description: [
                'ru' => 'Компактный и лёгкий пылесос для ежедневной уборки.',
                'en' => 'Compact and lightweight vacuum cleaner for daily cleaning.',
                'uz' => 'Kundalik tozalash uchun ixcham va yengil changyutgich.',
            ],
            price_old: null,
            price_new: null,
            images: [
                'kva2_1.jpg',
                'kva2_2.jpg',
                'kva2_3.jpg',
            ],
            specs: [
                ['Battery pack', '100 – 240 V'],
                ['Noise level', '< 78 dB'],
                ['Weight', '2.1 kg'],
                ['Charging time', '240 min'],
            ],
            equipment: [
                'HEPA filter',
                'Slot nozzle',
                'Brush attachment 2-in-1',
                'Wall mount',
            ]
        );

        $this->addProduct(
            category: $vacuum,
            code: '1.198-670',
            name: [
                'ru' => 'KVA 2',
                'en' => 'KVA 2 Vacuum Cleaner',
                'uz' => 'KVA 2 Changyutgich',
            ],
            description: [
                'ru' => 'Компактный и лёгкий пылесос для ежедневной уборки.',
                'en' => 'Compact and lightweight vacuum cleaner for daily cleaning.',
                'uz' => 'Kundalik tozalash uchun ixcham va yengil changyutgich.',
            ],
            price_old: null,
            price_new: null,
            images: [
                'kva2_1.jpg',
                'kva2_2.jpg',
                'kva2_3.jpg',
            ],
            specs: [
                ['Battery pack', '100 – 240 V'],
                ['Noise level', '< 78 dB'],
                ['Weight', '2.1 kg'],
                ['Charging time', '240 min'],
            ],
            equipment: [
                'HEPA filter',
                'Slot nozzle',
                'Brush attachment 2-in-1',
                'Wall mount',
            ]
        );
        // -------------------------------
        // 2) Минимойка K3
        // -------------------------------
        $this->addProduct(
            category: $wash,
            code: '1.676-100',
            name: [
                'ru' => 'Karcher K3',
                'en' => 'Karcher K3 Pressure Washer',
                'uz' => 'Karcher K3 Yuvish Apparati',
            ],
            description: [
                'ru' => 'Бытовая минимойка для чистки авто и двора.',
                'en' => 'Home pressure washer for car and yard cleaning.',
                'uz' => 'Avtomobil va hovlini yuvish uchun uy sharoitidagi minimoyka.',
            ],
            images: [
                'k3_1.jpg',
                'k3_2.jpg',
            ],
            specs: [
                ['Pressure', '120 bar'],
                ['Flow rate', '380 l/h'],
                ['Motor type', 'Universal'],
                ['Weight', '5.4 kg'],
            ],
            equipment: [
                'Gun',
                'High-pressure hose 6m',
                'Dirt blaster',
            ]
        );

        // -------------------------------
        // 3) Пароочиститель SC2
        // -------------------------------
        $this->addProduct(
            category: $steam,
            code: '1.512-050',
            name: [
                'ru' => 'Karcher SC2',
                'en' => 'Karcher SC2 Steam Cleaner',
                'uz' => 'Karcher SC2 Bug Tozalagich',
            ],
            description: [
                'ru' => 'Пароочиститель для генеральной уборки.',
                'en' => 'Steam cleaner for deep cleaning.',
                'uz' => 'Yirik tozalash uchun bug tozalagich.',
            ],
            images: [
                'sc2_1.jpg',
                'sc2_2.jpg',
            ],
            specs: [
                ['Heating output', '1500 W'],
                ['Heat-up time', '6.5 min'],
                ['Tank capacity', '1 L'],
            ],
            equipment: [
                'Floor nozzle',
                'Hand nozzle',
                'Brush set',
            ]
        );
    }

    private function addProduct(
        Category $category,
        string $code,
        array $name,
        array $description,
        array $images,
        array $specs,
        array $equipment,
        ?int $price_old = null,
        ?int $price_new = null,
    ): void
    {
        // Создаём продукт
        $product = Product::create([
            'category_id' => $category->id,
            'code' => $code,
            'price_old' => $price_old,
            'price_new' => $price_new,
            'image_main' => $images[0] ?? null,
            'images' => $images,
            'catalog_images' => $images,
            'specifications' => $specs,
            'equipment' => $equipment,
            'is_hit' => true,
            'is_new' => true,
            'is_recommended' => false,
            'is_sale' => false,
        ]);

        // Создаём переводы
        foreach (['ru', 'en', 'uz'] as $locale) {
            $product->translations()->create([
                'locale' => $locale,
                'name' => $name[$locale],
                'slug' => Str::slug($name[$locale]),
                'short_description' => $description[$locale],
                'description' => $description[$locale],
                'description_html' => '<p>' . $description[$locale] . '</p>',
                'specifications_html' => null,
                'equipment_html' => null,
                'meta_title' => $name[$locale],
                'meta_description' => $description[$locale],
                'meta_keywords' => null,
            ]);
        }
    }
}

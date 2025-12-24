<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageTranslation;
use Carbon\Carbon;

class PolicyPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'is_published' => true,
                'publish_date' => Carbon::now(),
                'is_menu' => false,
                'meta_robots' => 'index,follow',
                'canonical_url' => url('/privacy-policy'),
            ]
        );

        $translations = [
            'ru' => [
                'title' => 'Политика конфиденциальности',
                'excerpt' => 'Информация о сборе, хранении и обработке персональных данных.',
                'content' => '<p>Настоящая Политика конфиденциальности определяет порядок обработки и защиты персональных данных пользователей сайта.</p>',
                'meta_title' => 'Политика конфиденциальности',
                'meta_description' => 'Политика конфиденциальности и обработки персональных данных.',
            ],
            'en' => [
                'title' => 'Privacy Policy',
                'excerpt' => 'Information about the collection and processing of personal data.',
                'content' => '<p>This Privacy Policy describes how we collect, use, and protect your personal data.</p>',
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Privacy policy and personal data processing information.',
            ],
            'uz' => [
                'title' => 'Maxfiylik siyosati',
                'excerpt' => 'Shaxsiy maʼlumotlarni yigʻish va qayta ishlash haqida maʼlumot.',
                'content' => '<p>Ushbu Maxfiylik siyosati sayt foydalanuvchilarining shaxsiy maʼlumotlarini qayta ishlash tartibini belgilaydi.</p>',
                'meta_title' => 'Maxfiylik siyosati',
                'meta_description' => 'Shaxsiy maʼlumotlarni qayta ishlash qoidalari.',
            ],
        ];

        foreach ($translations as $locale => $data) {
            PageTranslation::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'locale' => $locale,
                ],
                $data
            );
        }
    }
}

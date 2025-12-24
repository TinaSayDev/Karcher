<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageTranslation;
use Carbon\Carbon;

class StaticPagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'about' => [
                'slug' => 'about',
                'translations' => [
                    'ru' => [
                        'title' => 'О нас',
                        'excerpt' => 'Информация о компании, нашей миссии и ценностях.',
                        'content' => '<p>Мы — компания, предоставляющая качественные услуги и решения для наших клиентов.</p>',
                        'meta_title' => 'О компании',
                        'meta_description' => 'Информация о компании, нашей миссии и опыте работы.',
                    ],
                    'en' => [
                        'title' => 'About Us',
                        'excerpt' => 'Information about our company, mission and values.',
                        'content' => '<p>We are a company providing high-quality services and solutions for our clients.</p>',
                        'meta_title' => 'About Us',
                        'meta_description' => 'Learn more about our company, mission and experience.',
                    ],
                    'uz' => [
                        'title' => 'Biz haqimizda',
                        'excerpt' => 'Kompaniya, missiya va qadriyatlar haqida maʼlumot.',
                        'content' => '<p>Biz mijozlarimizga sifatli xizmatlar va yechimlar taqdim etuvchi kompaniyamiz.</p>',
                        'meta_title' => 'Biz haqimizda',
                        'meta_description' => 'Kompaniya, missiya va tajriba haqida maʼlumot.',
                    ],
                ],
            ],

            'license' => [
                'slug' => 'license',
                'translations' => [
                    'ru' => [
                        'title' => 'Лицензия',
                        'excerpt' => 'Информация о лицензиях и разрешениях компании.',
                        'content' => '<p>Компания осуществляет деятельность на основании действующих лицензий и разрешений.</p>',
                        'meta_title' => 'Лицензия компании',
                        'meta_description' => 'Информация о лицензиях и разрешительных документах компании.',
                    ],
                    'en' => [
                        'title' => 'License',
                        'excerpt' => 'Information about company licenses and permits.',
                        'content' => '<p>The company operates on the basis of valid licenses and permits.</p>',
                        'meta_title' => 'Company License',
                        'meta_description' => 'Information about company licenses and permits.',
                    ],
                    'uz' => [
                        'title' => 'Litsenziya',
                        'excerpt' => 'Kompaniya litsenziyalari va ruxsatnomalari haqida maʼlumot.',
                        'content' => '<p>Kompaniya amaldagi litsenziya va ruxsatnomalar asosida faoliyat yuritadi.</p>',
                        'meta_title' => 'Kompaniya litsenziyasi',
                        'meta_description' => 'Litsenziyalar va ruxsatnomalar haqida maʼlumot.',
                    ],
                ],
            ],

            'contacts' => [
                'slug' => 'contacts',
                'translations' => [
                    'ru' => [
                        'title' => 'Контакты',
                        'excerpt' => 'Контактная информация и способы связи с компанией.',
                        'content' => '
                            <p><strong>Адрес:</strong> г. Ташкент</p>
                            <p><strong>Телефон:</strong> +998 00 000 00 00</p>
                            <p><strong>Email:</strong> info@example.com</p>
                        ',
                        'meta_title' => 'Контакты компании',
                        'meta_description' => 'Контактная информация, адрес и способы связи.',
                    ],
                    'en' => [
                        'title' => 'Contacts',
                        'excerpt' => 'Contact details and ways to get in touch.',
                        'content' => '
                            <p><strong>Address:</strong> Tashkent</p>
                            <p><strong>Phone:</strong> +998 00 000 00 00</p>
                            <p><strong>Email:</strong> info@example.com</p>
                        ',
                        'meta_title' => 'Company Contacts',
                        'meta_description' => 'Contact details, address and communication methods.',
                    ],
                    'uz' => [
                        'title' => 'Aloqa',
                        'excerpt' => 'Kompaniya bilan bogʻlanish uchun aloqa maʼlumotlari.',
                        'content' => '
                            <p><strong>Manzil:</strong> Toshkent</p>
                            <p><strong>Telefon:</strong> +998 00 000 00 00</p>
                            <p><strong>Email:</strong> info@example.com</p>
                        ',
                        'meta_title' => 'Aloqa maʼlumotlari',
                        'meta_description' => 'Manzil, telefon va email aloqa maʼlumotlari.',
                    ],
                ],
            ],
        ];

        foreach ($pages as $pageData) {
            $page = Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                [
                    'is_published' => true,
                    'publish_date' => Carbon::now(),
                    'is_menu' => true,
                    'meta_robots' => 'index,follow',
                    'canonical_url' => url('/' . $pageData['slug']),
                ]
            );

            foreach ($pageData['translations'] as $locale => $translation) {
                PageTranslation::updateOrCreate(
                    [
                        'page_id' => $page->id,
                        'locale' => $locale,
                    ],
                    $translation
                );
            }
        }
    }
}

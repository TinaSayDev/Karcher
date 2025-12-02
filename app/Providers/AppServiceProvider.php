<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use function PHPUnit\TestFixture\func;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Inertia::share([
            'mainmenu' => function () {
                return [
                    'catalog' => __('mainmenu.catalog'),
                    'home_garden' => __('mainmenu.home_garden'),
                    'professional' => __('mainmenu.professional'),
                    'purchase_service' => __('mainmenu.purchase_service'),
                    'about' => __('mainmenu.about'),
                    'blog' => __('mainmenu.blog'),
                ];
            },
            'catalog_menu' => function () {
                return [
                    'hit' => __('product.hit'),
                    'new' => __('product.new'),
                    'recommended' => __('product.recommended'),
                    'sale' => __('product.sale'),
                ];

            }
        ]);
    }
}

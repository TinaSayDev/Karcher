<?php


namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Log::info('FilamentServiceProvider booted');

        // Фильтруем доступ к админке
        Filament::serving(function () {

            // Разрешаем доступ только определённым пользователям
            Filament::auth(function ($user) {
                // Вариант 1: разрешаем конкретному email
               // return $user->email === 'admin@example.com';

                // Вариант 2: разрешаем всем пользователям с ролью admin
                // return $user->role === 'admin';

                // Вариант 3: разрешаем всем зарегистрированным пользователям (только для теста)
                 return true;
            });
        });
    }
}

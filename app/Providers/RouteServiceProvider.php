<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    // Маршрутные файлы для приложения
    public function boot(): void
    {
        $this->routes(function () {
            // Загружаем API маршруты с префиксом "api" и middleware "api"
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            // Загружаем веб маршруты с middleware "web"
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
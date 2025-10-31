<?php

return [
    'name' => env('APP_NAME', 'Crietto'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'locale' => 'ja',
    'fallback_locale' => 'en',

    'providers' => [
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Laravel\Sanctum\SanctumServiceProvider::class,
    ],
];

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// 1. Trik runtime check untuk membuat folder cache di /tmp Vercel
if (isset($_SERVER['VERCEL_URL'])) {
    $targetDirectories = [
        'bootstrap/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/framework/cache'
    ];
    foreach ($targetDirectories as $dir) {
        if (!is_dir('/tmp/' . $dir)) {
            mkdir('/tmp/' . $dir, 0755, true);
        }
    }
}

// 2. Tampung konfigurasi ke dalam variabel $app
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\CheckActiveStatus::class,
        ]);
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'admin' => \App\Http\Middleware\Admin::class,
            'pet_owner' => \App\Http\Middleware\PetOwnerOnly::class,
            'service_provider' => \App\Http\Middleware\ServiceProviderOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// 3. Alihkan storage path Laravel ke /tmp khusus di lingkungan Vercel
if (isset($_SERVER['VERCEL_URL'])) {
    $app->useStoragePath('/tmp/storage');
}

// 4. Kembalikan instance $app agar kernel Laravel tetap berjalan normal
return $app;
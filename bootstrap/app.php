<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
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
    })
    ->booting(function ($app) {
        // Jalankan trik /tmp Vercel tepat saat aplikasi sedang bersiap booting
        if (isset($_SERVER['VERCEL_URL'])) {
            $targetDirectories = [
                'bootstrap/cache',
                'storage/framework/sessions',
                'storage/framework/views',
                'storage/framework/cache',
                'storage/logs'
            ];
            foreach ($targetDirectories as $dir) {
                if (!is_dir('/tmp/' . $dir)) {
                    mkdir('/tmp/' . $dir, 0755, true);
                }
            }

            // Alihkan penyimpanan rute internal & view compile ke /tmp
            $app->useStoragePath('/tmp/storage');
            config(['view.compiled' => '/tmp/bootstrap/cache']);
        }
    })
    ->create();
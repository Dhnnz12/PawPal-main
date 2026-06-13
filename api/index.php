<?php

// 1. Muat Composer Autoloader bawaan Linux Vercel
require __DIR__ . '/../vendor/autoload.php';

// Amankan runtime environment Serverless Vercel
if (isset($_ENV['VERCEL_URL']) || isset($_SERVER['VERCEL_URL'])) {
    // Pastikan env cache path diatur sebelum config di-load
    $_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
    $_ENV['APP_SERVICES_CACHE'] = '/tmp/storage/bootstrap/cache/services.php';
    $_ENV['APP_PACKAGES_CACHE'] = '/tmp/storage/bootstrap/cache/packages.php';
    $_ENV['APP_CONFIG_CACHE'] = '/tmp/storage/bootstrap/cache/config.php';
    $_ENV['APP_ROUTES_CACHE'] = '/tmp/storage/bootstrap/cache/routes-v7.php';
    $_ENV['APP_EVENTS_CACHE'] = '/tmp/storage/bootstrap/cache/events.php';
}

// 2. Inisialisasi Jantung Aplikasi Laravel 12
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Amankan runtime environment Serverless Vercel
if (isset($_ENV['VERCEL_URL']) || isset($_SERVER['VERCEL_URL'])) {
    // Alihkan storage internal ke /tmp (direktori yang memiliki izin WRITE)
    $app->useStoragePath('/tmp/storage');

    // Pastikan folder kompilasi view dan cache tersedia di memori sementara
    $directories = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/app/public',
        '/tmp/storage/logs',
        '/tmp/storage/bootstrap/cache'
    ];
    
    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

}

// 4. Bangun HTTP Kernel & Jalankan Siklus Hidup Request secara Utuh
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
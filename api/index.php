<?php

// 1. Muat Composer Autoloader yang baru di-install oleh Vercel
require __DIR__ . '/../vendor/autoload.php';

// 2. Ambil Instance Aplikasi Laravel 12
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Amankan konfigurasi View & Storage untuk environment Vercel
if (isset($_SERVER['VERCEL_URL'])) {
    // Alihkan storage path utama ke folder /tmp (satu-satunya folder yang bisa ditulis)
    $app->useStoragePath('/tmp/storage');

    // Buat folder cache views secara paksa jika belum tersedia
    if (!is_dir('/tmp/storage/framework/views')) {
        mkdir('/tmp/storage/framework/views', 0755, true);
    }

    // Set konfigurasi compiled views ke /tmp sebelum kernel dijalankan
    config(['view.compiled' => '/tmp/storage/framework/views']);

    // Daftarkan ViewServiceProvider secara eksplisit ke Service Container
    $app->register(\Illuminate\View\ViewServiceProvider::class);
}

// 4. Bangun HTTP Kernel dan Proses Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
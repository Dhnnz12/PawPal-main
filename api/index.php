<?php

// 1. Muat Composer Autoloader bawaan Linux Vercel
require __DIR__ . '/../vendor/autoload.php';

// 2. Inisialisasi Jantung Aplikasi Laravel 12
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Amankan runtime environment Serverless Vercel
if (isset($_SERVER['VERCEL_URL'])) {
    // Alihkan storage internal ke /tmp (direktori yang memiliki izin WRITE)
    $app->useStoragePath('/tmp/storage');

    // Pastikan folder kompilasi view tersedia di memori sementara
    if (!is_dir('/tmp/storage/framework/views')) {
        mkdir('/tmp/storage/framework/views', 0755, true);
    }

    // Set jalur kompilasi blade secara eksplisit
    config(['view.compiled' => '/tmp/storage/framework/views']);

    // BYPASS BINDING RESOLUTION ERROR (Memaksa registrasi komponen View)
    $app->register(\Illuminate\View\ViewServiceProvider::class);
}

// 4. Bangun HTTP Kernel & Jalankan Siklus Hidup Request secara Utuh
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
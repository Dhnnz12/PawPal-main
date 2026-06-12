<?php

// 1. Muat Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 2. Ambil Instance Aplikasi Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Bangun HTTP Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// 4. Tangkap Request & Proses Melalui Lifecycle Bootstrapping Lengkap
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// 5. Kirim Response Balik ke Browser
$response->send();

// 6. Selesaikan Siklus Hidup Request
$kernel->terminate($request, $response);
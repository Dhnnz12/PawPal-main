<?php

// Ambil autoloader vendor
require __DIR__ . '/../vendor/autoload.php';

// Panggil jantung aplikasi Laravel 12
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Jalankan HTTP Kernel utama
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
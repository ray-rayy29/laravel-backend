<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // Path API yang diizinkan

    'allowed_methods' => ['*'],  // Izinkan semua method (GET, POST, PUT, DELETE, OPTIONS)

    'allowed_origins' => [
        'http://localhost:3000',           // Untuk development local
        'https://nama-project.vercel.app', // Nanti ganti dengan domain Vercel Anda
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],  // Izinkan semua header

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,  // Penting untuk autentikasi

];
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    | This file allows you to configure your settings for cross-origin resource
    | sharing or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173',  // Public website (dev)
        'http://localhost:5174',  // Admin panel (dev)
        'http://127.0.0.1:5173',
        'http://127.0.0.1:5174',
        // Add your production domains here:
        // 'https://www.vtkindergarten.com',
        // 'https://admin.vtkindergarten.com',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];

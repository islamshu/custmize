<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define the configuration options for CORS requests.
    |
    */

    'paths' => [
        'api/*', // Apply CORS to API routes
        'oauth/*', // Include Passport routes like token and clients
        'sanctum/csrf-cookie', // Optional if you're using Sanctum
    ],

    'allowed_origins' => ['*'],

    'allowed_methods' => [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'
    ],

    'allowed_headers' => [
        'Content-Type',
        'X-Auth-Token',
        'X-Requested-With',
        'Authorization', // Allow Authorization header for OAuth tokens
        'Accept',
    ],

    'exposed_headers' => [
        'Authorization', // Expose Authorization header to front-end
    ],

    'max_age' => 60 * 60 * 24, // Allow caching for a day

    'supports_credentials' => true, // Enable credentials for Passport tokens
];

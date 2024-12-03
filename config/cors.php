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

    'allowed_origins' => [
        '*', // Allow all origins (for development) - Replace with specific origins in production
        'http://front.custmize.digitalgo.net' // Allow specific origin
    ],

    'allowed_methods' => [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'
    ],

    'allowed_headers' => [
        'Content-Type',
        'X-Auth-Token',
        'X-Requested-With',
        'Authorization'
    ],

    'exposed_headers' => [
         // ... any headers you want to expose to the client
    ],

    'max_age' => 60 * 60 * 24, // Allow caching for a day

    'supports_credentials' => false, // Set to true if cookies are passed in cross-origin requests
];
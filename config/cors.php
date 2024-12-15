<?php
return [
    'paths' => ['api/*', 'oauth/*'], // Apply CORS to API and Passport routes

    'allowed_methods' => ['*'], // Allow all HTTP methods

    'allowed_origins' => [
        'http://printlogo.custmize.digitalgo.net', // Your front-end domain
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => ['Authorization'], // Expose Authorization header

    'max_age' => 0,

    'supports_credentials' => true, // Set to true if using cookies or credentials
];

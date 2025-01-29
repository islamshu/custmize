<?php
return [
    'paths' => ['api/*', 'storage/*'], // Paths to apply CORS
    'allowed_methods' => ['*'], // Allowed HTTP methods
    'allowed_origins' => ['https://printlogo.custmize.digitalgo.net'], // Allowed origins
    'allowed_headers' => ['*'], // Allowed headers
    'exposed_headers' => [], // Exposed headers
    'max_age' => 0, // Max age
    'supports_credentials' => false, // Allow credentials
];
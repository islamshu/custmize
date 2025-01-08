<?php
return [
    'paths' => ['api/*', 'storage/uploads/*'], // Specify the paths you want to allow
    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, etc.)
    'allowed_origins' => ['*'], // Allow requests from all origins
    'allowed_origins_patterns' => [], // Keep this empty
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [], // No specific headers to expose
    'max_age' => 0, // No caching for preflight requests
    'supports_credentials' => false, // Set to true if cookies are needed for cross-origin requests
];

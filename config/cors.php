<?php

return [
    'paths' => ['api/*', 'storage/uploads/*'], // Specify the paths you want to allow

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://printlogo.custmize.digitalgo.net',
        'http://printlogo.custmize.digitalgo.net'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
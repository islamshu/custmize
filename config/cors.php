<?php

return [
'paths' => ['api/*', 'viwer/*', 'storage/uploads/*', '*'],

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
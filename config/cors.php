<?php

return [

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    | Frontend domainlar
    */
    'allowed_origins' => [
        'https://bazzaro.uz',
        'https://www.bazzaro.uz',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    | Agar Sanctum / cookie auth ishlatilsa TRUE bo‘lishi shart
    */
    'supports_credentials' => true,
];

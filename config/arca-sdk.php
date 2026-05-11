<?php

return [
    'env' => 'testing',

    'cuit' => env('ARCA_CUIT', '20275293556'),

    'directory' => storage_path('app/arca'),

    'private_key' => 'arca.key',
    'public_cert' => 'arca.crt',

    'passphrase' => null,

    'cache_key' => 'laravel-arca-sdk-ta',
    'cache_ttl' => 3600 * 12,

    'wsdl_url' => [
        'wsaa' => [
            'testing' => 'https://wsaahomo.afip.gov.ar/ws/services/LoginCms?WSDL',
        ],
        'wsfe' => [
            'testing' => 'https://wswhomo.afip.gov.ar/wsfev1/service.asmx?WSDL',
        ],
    ],
];

<?php
return [
    // Your application namespaces, where we should look for bundles
    'namespaces' => [
        'Integrations' => base_path() . DIRECTORY_SEPARATOR . 'integrations',
        'Api' => base_path() . DIRECTORY_SEPARATOR . 'api',
    ],

    // Middleware that should be included in every .routes.php
    'protection_middleware' => [
    ],

    // Middleware that should be included in every public_routes.php
    'middleware' => [
    ],
];

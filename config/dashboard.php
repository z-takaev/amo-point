<?php

declare(strict_types=1);

return [
    'admin' => [
        'name' => env('DASHBOARD_ADMIN_NAME', 'AmoPoint'),
        'email' => env('DASHBOARD_ADMIN_EMAIL', 'admin@amopoint.test'),
        'password' => env('DASHBOARD_ADMIN_PASSWORD', 'password'),
    ],
];

<?php

return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=' . env('DB_HOST', 'localhost')
                . ';port=' . env('DB_PORT', '3306')
                . ';dbname=' . env('DB_TEST_NAME', 'industrial_attachment_test'),
            'charset' => 'utf8mb4',
        ],
    ],
];

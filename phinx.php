<?php

namespace AdoptOrNot\Api;

// Require bootstrap file
require_once __DIR__ . '/src/bootstrap.php';

// Phinx
return [
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeds'
    ],
    'environments' => [
        'default_migration_table' => '_migrations',
        'default_database' => 'production',
        'production' => [
            'adapter' => 'mysql',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'host' => env('ADOPTORNOT_MYSQL_HOSTNAME', 'localhost'),
            'user' => env('ADOPTORNOT_MYSQL_USERNAME', ''),
            'pass' => env('ADOPTORNOT_MYSQL_PASSWORD', ''),
            'name' => env('ADOPTORNOT_MYSQL_DATABASE', ''),
            'port' => 3306
        ]
    ]
];
<?php

namespace AdoptOrNot\Api;
use \Slim\App as SlimApp;

// Include core bootstrap file
require_once '../src/bootstrap.php';

// Setup application
$app = new SlimApp([
    'settings' => [
        // TODO: only set in DEV env
        'displayErrorDetails' => true,
        'database' => [
            'hostname' => env('ADOPTORNOT_MYSQL_HOSTNAME', 'localhost'),
            'username' => env('ADOPTORNOT_MYSQL_USERNAME'),
            'password' => env('ADOPTORNOT_MYSQL_PASSWORD'),
            'database' => env('ADOPTORNOT_MYSQL_DATABASE')
        ]
    ]
]);

// Add dependencies
$container = $app->getContainer();
$container['db'] = function ($c) {
    $config = $c['settings']['db.connection'];
    $dsn = sprintf('mysql:host=%s;dbname=%s', $config['hostname'], $config['database']);
    $pdo = new \PDO($dsn, $config['username'], $config['password']);
    return $pdo;
};

// Main application route
$app->get('/', function ($request, $response) {
    return $response->withJson('Hello World!');
});

// Execute
$app->run();
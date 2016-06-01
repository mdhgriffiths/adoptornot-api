<?php

namespace AdoptOrNot\Api;
use \Slim\App as SlimApp;

// TODO: error handler to return valid JSON response
// TODO: implement API authentication / rate limiting

// Include core bootstrap file
require_once '../src/bootstrap.php';

// Setup application
$app = new SlimApp([
    'settings' => [
        'outputBuffering' => false,
        // TODO: disable errors in prod.
        'displayErrorDetails' => true,
        'database' => [
            'hostname' => env('ADOPTORNOT_MYSQL_HOSTNAME', 'localhost'),
            'username' => env('ADOPTORNOT_MYSQL_USERNAME'),
            'password' => env('ADOPTORNOT_MYSQL_PASSWORD'),
            'database' => env('ADOPTORNOT_MYSQL_DATABASE')
        ]
    ]
]);

// Setup application dependencies
require_once '../src/container.php';

// Main application route (search for animals)
$app->get('/', Controller\SearchAnimals::class);

// Execute
$app->run();
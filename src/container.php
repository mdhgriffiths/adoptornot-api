<?php

namespace AdoptOrNot\Api;

// ContainerInterface
$container = $app->getContainer();

// PDO database connection
$container['db'] = function ($c) {
    $config = $c['settings']['db.connection'];
    $dsn = sprintf('mysql:host=%s;dbname=%s', $config['hostname'], $config['database']);
    $pdo = new \PDO($dsn, $config['username'], $config['password']);
    return $pdo;
};

// RescueGroup API client
$container['api'] = function ($c) {
    $apiKey = env('RESCUEGROUPS_APIKEY');
    return new RescueGroups\ApiClient($apiKey);
};

// Search controller
$container[Controller\SearchAnimals::class] = function ($c) {
    return new Controller\SearchAnimals($c->api);
};
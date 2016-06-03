<?php

namespace AdoptOrNot\Api;

// ContainerInterface
$container = $app->getContainer();

// RescueGroup API client
$container['api'] = function ($c) {
    $apiKey = env('RESCUEGROUPS_APIKEY');
    return new RescueGroups\ApiClient($apiKey);
};

// Search controller
$container[Controller\SearchAnimals::class] = function ($c) {
    return new Controller\SearchAnimals($c->api);
};

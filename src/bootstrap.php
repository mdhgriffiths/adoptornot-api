<?php

namespace AdoptOrNot\Api;
use \Dotenv\Dotenv;

// Let's see everything
error_reporting(E_ALL);

// Composer autoload has it all
$root_path = realpath(__DIR__ . '/..') . '/';
require_once __DIR__ . '/../vendor/autoload.php';

// Load $_ENV from .env file
$dotenv = new Dotenv($root_path);
$dotenv->load();

// Check required $_ENV variables
$required = ['RESCUEGROUPS_APIKEY'];
$dotenv->required($required)->notEmpty();

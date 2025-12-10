<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Detect environment (hosting / local)
$isHosting = str_contains(__DIR__, 'public_html');

// Path base folder
$basePath = $isHosting ? __DIR__ . '/../watchstire' : __DIR__ . '/..';

// Maintenance mode...
if (file_exists($maintenance = $basePath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoload (composer)
require $basePath . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once $basePath . '/bootstrap/app.php';

// Handle request
$app->handleRequest(Request::capture());

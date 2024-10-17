<?php

// Load the composer autoload file
require __DIR__ . '/../vendor/autoload.php';

/**
 * Create a new application instance from the bootstrap file
 * 
 * @var \Core\Foundation\Application $app
 */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Capture the incoming request
$request = Core\Foundation\Http\Request::capture();

/**
 * Get the kernel instance
 * 
 * @var \Core\Foundation\Kernel $kernel
 */
$kernel = $app->make(Core\Foundation\Kernel::class);

// Handle the incoming request
$response = $kernel->handle($request);

// Then send the response back to the browser
$kernel->terminate($request, $response);

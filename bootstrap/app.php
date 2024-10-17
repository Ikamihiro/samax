<?php

// Create a new application instance
$app = new Core\Foundation\Application(
    __DIR__ . '/../'
);

// Register the kernel instance
$app->singleton(
    Core\Foundation\Kernel::class,
    App\Http\Kernel::class
);

// Return the application instance
return $app;
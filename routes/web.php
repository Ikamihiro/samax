<?php

use App\Http\Controllers\RootController;
use App\Http\Middlewares\Authenticated;

router()->get('/', [RootController::class, 'index'])->setMiddleware(Authenticated::class);

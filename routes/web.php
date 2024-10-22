<?php

use App\Http\Controllers\RootController;

router()->get('/', [RootController::class, 'index']);

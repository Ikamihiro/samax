<?php

use Core\Foundation\Http\Request;
use Core\Foundation\Http\Response;

router()->get('/', function (Request $request, Response $response) {
    return $response->json([
        'message' => 'Root',
        ...$request->all()
    ]);
});

router()->post('/', function (Request $request, Response $response) {
    return $response->json([
        'message' => 'Post',
        ...$request->all()
    ]);
});

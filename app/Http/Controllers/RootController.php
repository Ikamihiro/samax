<?php

namespace App\Http\Controllers;

use Core\Foundation\Http\Controller;

class RootController extends Controller
{
    public function index()
    {
        $users = database()->query('SELECT id, first_name, email FROM users')->get();

        return response()->json([
            'message' => 'Hello, World!',
            'users' => $users
        ]);
    }
}
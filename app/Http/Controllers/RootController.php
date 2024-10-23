<?php

namespace App\Http\Controllers;

use App\Http\Controller;

class RootController extends Controller
{
    public function index()
    {
        $users = database()
            ->query('SELECT id, full_name, email FROM users')
            ->get();

        return response()->json($users);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Repositories\UserRepository;

class RootController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function index()
    {
        $users = database()
            ->query('SELECT id, full_name, email FROM users')
            ->get();

        return response()->json($users);
    }
}

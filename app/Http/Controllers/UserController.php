<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('user/Index', ['users' => User::with('roles')->get()]);
    }

    public function show(User $user)
    {
        return Inertia::render('user/Show', [
            'user' => $user->load('roles.permissions', 'frames'),
        ]);
    }
}

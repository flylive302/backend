<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', auth()->user());
        return Inertia::render('user/Index', ['users' => User::with('roles')->get()]);
    }

    public function show(User $user)
    {
        $this->authorize('view', auth()->user());

//        dd($user->load('roles.permissions', 'frames', 'initiatedTransactions', 'receivedTransactions')->toArray());

        return Inertia::render('user/Show', [
            'user' => $user->load('roles.permissions', 'frames', 'initiatedTransactions', 'receivedTransactions'),
        ]);
    }
}

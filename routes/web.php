<?php

use App\Http\Controllers\FrameController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::get('users', function () {
        return Inertia::render('Users', ['users' => User::all(), 'count' => User::count()]);
    })->name('users');

    Route::resource('frame', FrameController::class);

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

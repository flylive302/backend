<?php

use App\Models\Frame;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::get('users', function () {
        return Inertia::render('Users', ['users' => User::all(), 'count' => User::count()]);
    })->name('users');

    Route::get('frames', function () {
        return Inertia::render('frames/Index', ['frames' => Frame::all(), 'count' => Frame::count()]);
    })->name('frames');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

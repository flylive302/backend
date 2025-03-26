<?php

use App\Http\Controllers\FrameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('admin')) {
            return Inertia::render('Dashboard');
        } else {
            return Inertia::render('reseller/Index');
        }
    })->name('dashboard');

    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('users');

        Route::get('users/{user}', 'show')->name('users.show');
    });

    Route::resource('frame', FrameController::class);

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

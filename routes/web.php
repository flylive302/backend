<?php

use App\Http\Controllers\CoinRequestController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');
Route::inertia('/docs', 'Docs')->name('docs');

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

    Route::controller(CoinRequestController::class)->group(function () {
        Route::get('/coin-requests', 'index')->name('coinRequest.index');
        Route::post('/coin-requests', 'store')->name('coinRequest.store');
        Route::get('/coin-requests/create', 'create')->name('coinRequest.create');
        Route::get('/coin-requests/{coinRequest}/show', 'show')->name('coinRequest.show');

        // Admin routes
        Route::patch('/coin-requests/{coinRequest}/update', 'update')->name('coinRequest.update');
    });

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

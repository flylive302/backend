<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('users', function () {
        return Inertia::render('Users')->with('count', User::count());
    })->name('users');

});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

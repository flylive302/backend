<?php

use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health_check', function () {
    return response()->json(['status' => 'ok']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::get('/user', function (Request $request) { return $request->user(); });
});


Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [AuthenticationController::class, 'register']);

    Route::post('/login', [AuthenticationController::class, 'login']);
});

<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CoinRequestController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\FrameController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/health_check', function () {
    return response()->json(['status' => 'ok']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::get('/user', 'authUser');

        Route::get('/user/{user}', 'getUserById');

        Route::post('/logout', 'logout');

        Route::post('/reset-password', 'updatePassword');

        Route::patch('/update-profile', 'updateProfileField');
    });

    // Get Signed URL for File Uploads
    Route::post('/signed-url', [FileUploadController::class, 'getSignedUrl']);

    Route::controller(FrameController::class)->group(function () {
        Route::get('/frame/all', 'index');
        Route::get('/frame/my-frames', 'getMyFrames');

        Route::post('/frame/{frame}/purchase', 'purchase');
        Route::post('/frame/{frame}/activate', 'activate');
    });

    Route::controller(CoinRequestController::class)->group(function () {
        Route::get('/coin-resellers', 'getCoinResellers');
        Route::post('/coin-requests/{user}', 'store');
        Route::get('/coin-requests/{coinRequest}/show', 'show');
    });

    Route::controller(RoomController::class)->group(function () {
        Route::get('/rooms', 'index');
        Route::get('/room/{room}/view', 'show');
    });
});


Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [AuthenticationController::class, 'register']);

    Route::post('/login', [AuthenticationController::class, 'login']);
});

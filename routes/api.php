<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\FrameController;
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
        Route::get('/frame/all', 'getFrames')->name('frame.getFrames');
        Route::get('/frame/my-frames', 'getMyFrames')->name('frame.getMyFrames');

        Route::post('/frame/{frame}/purchase', 'purchase')->name('frame.purchase');
        Route::post('/frame/{frame}/activate', 'activate')->name('frame.activate');
    });
});


Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [AuthenticationController::class, 'register']);

    Route::post('/login', [AuthenticationController::class, 'login']);
});

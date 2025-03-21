<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\FileUploadController;
use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health_check', function () {
    return response()->json(['status' => 'ok']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [AuthenticationController::class, 'authUser']);

    Route::get('/user/{user}', [AuthenticationController::class, 'getUserById']);

    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::post('/reset-password', [AuthenticationController::class, 'updatePassword']);

    Route::patch('/update-profile', [AuthenticationController::class, 'updateProfileField']);

    // Get Signed URL for File Uploads
    Route::post('/signed-url', [FileUploadController::class, 'getSignedUrl']);

    Route::get('/frames', function () {
        return response()->json(['frames' => Frame::all()]);
    });
});


Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [AuthenticationController::class, 'register']);

    Route::post('/login', [AuthenticationController::class, 'login']);
});

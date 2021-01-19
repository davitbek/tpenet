<?php

use Illuminate\Support\Facades\Route;
use Api\V1\Http\Controllers\AuthUserController;
use Api\V1\Http\Middleware\ApiAuth;

Route::post('auth/register', [AuthUserController::class, 'register']);
Route::post('auth/activate', [AuthUserController::class, 'activate']);
Route::post('auth/login', [AuthUserController::class, 'login']);
Route::post('auth/login/refresh', [AuthUserController::class, 'refreshToken']);
Route::post('auth/password/forgot', [AuthUserController::class, 'forgotPassword']);
Route::post('auth/password/reset', [AuthUserController::class, 'resetPassword']);

Route::middleware(ApiAuth::class)->group(function () {
    // @TODO make route aliases
    // TODO  delete auth/user/
    Route::get('auth/user', [AuthUserController::class, 'getAuthUser']);
    Route::put('auth/user/update', [AuthUserController::class, 'updateAuth']);
    Route::put('auth/user/update/password', [AuthUserController::class, 'updateAuthPassword']);
    Route::delete('auth/user/delete', [AuthUserController::class, 'deleteAuth']);
});

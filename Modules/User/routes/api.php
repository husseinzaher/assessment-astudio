<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\AuthController;
use Modules\User\Http\Controllers\Api\UserController;

Route::middleware([\App\Enums\Guard::User->middleware()])->group(function () {
    Route::apiResource('users', UserController::class)->names('users');
});

Route::middleware('throttle:500,1')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout')->middleware(\App\Enums\Guard::User->middleware());
    });

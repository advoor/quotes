<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthentication;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [UserController::class, 'authenticate']);

Route::group(['middleware' => ApiAuthentication::class], function () {
    Route::get('/profile', [UserController::class, 'profile']);
});

<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthentication;
use Illuminate\Support\Facades\Route;

Route::post('/user', [UserController::class, 'authenticate']);

Route::group(['middleware' => ApiAuthentication::class], function () {
    Route::get('/user', [UserController::class, 'show']);
});

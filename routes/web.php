<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'login_page']);

Route::middleware([UserMiddleware::class])->group(function () {
    Route::get('/', [UserController::class, 'index']);
});

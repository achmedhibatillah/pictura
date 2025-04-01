<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserCogController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/s', function () { return response()->json(Session::all()); });
Route::get('d', function() { Session::flush(); return redirect()->back(); });

Route::middleware([GuestMiddleware::class])->group(function () {
    Route::get('login', [AuthController::class, 'login_page']);
    Route::post('login', [AuthController::class, 'login_auth']);
    Route::get('register', [AuthController::class, 'register_page']);
    Route::post('register', [AuthController::class, 'register_auth']);
});

Route::middleware([UserMiddleware::class])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('usr/{slug}', [UserController::class, 'profile']);
    Route::get('edit-profile', [UserController::class, 'profile_edit']);
    Route::post('edit-profile/name', [UserCogController::class, 'edit_name']);
    Route::post('edit-profile/email', [UserCogController::class, 'edit_email']);
    Route::post('edit-profile/pass', [UserCogController::class, 'edit_pass']);
    Route::post('edit-profile/photo', [UserCogController::class, 'edit_photo']);
    Route::post('edit-profile/desc', [UserCogController::class, 'edit_desc']);

    Route::post('req/connect', [UserCogController::class, 'connect_connecting']);
    Route::post('req/disconnect', [UserCogController::class, 'connect_disconnect']); 
});

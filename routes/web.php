<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SuperUserController;
use App\Http\Controllers\UserCogController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\SuperUserMiddleware;
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

    Route::post('post/like', [PostController::class, 'post_like']);

    Route::get('new-post', [UserController::class, 'post_new']);
    Route::get('new-post/{slug}', [UserController::class, 'post_new']);
    Route::post('new-post/share', [PostController::class, 'post_share']);
    Route::post('new-post/desc/edit', [PostController::class, 'post_desc_edit']);
    Route::post('new-post/image/add', [PostController::class, 'post_image_new']);
    Route::post('new-post/image/up', [PostController::class, 'post_image_up']);
    Route::post('new-post/image/down', [PostController::class, 'post_image_down']);
    Route::post('new-post/image/del', [PostController::class, 'post_image_del']);
    Route::get('edit-post/{slug}', [UserController::class, 'post_edit']);
    Route::post('edit-post/update', [PostController::class, 'post_update']);
    Route::post('del-post', [PostController::class, 'post_del']);

    Route::post('req/connect', [UserCogController::class, 'connect_connecting']);
    Route::post('req/disconnect', [UserCogController::class, 'connect_disconnect']);

    Route::get('find-people', [UserController::class, 'people']); 
    Route::get('notification', [UserController::class, 'notification']);

});

Route::middleware([SuperUserMiddleware::class])->group(function () {
    Route::get('manage-users', [SuperUserController::class, 'index']);
    Route::get('manage-users/edit/{slug}', [SuperUserController::class, 'user_edit']);
    Route::post('manage-users/add', [SuperUserController::class, 'user_add']);
    Route::post('manage-users/del', [SuperUserController::class, 'user_del']);
});
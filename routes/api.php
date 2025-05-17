<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostImageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Группа маршрутов для неавторизованных пользователей
Route::group([], function () {
    Route::post('/login', [LoginController::class, 'apiLogin']);
    Route::post('/register', [RegisterController::class, 'apiRegister']);
});

// Группа маршрутов, доступных только авторизованным пользователям
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/following/posts', [UserController::class, 'followingPost']);
    Route::get('/users/{user}/posts', [UserController::class, 'post']);
    Route::get('/users/{user}/toggle_following', [UserController::class, 'toggleFollowing']);

    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/post/images', [PostImageController::class, 'store']);
    Route::post('/posts/{post}/toggle_like', [PostController::class, 'toggleLike']);

    Route::post('/logout', [LoginController::class, 'logoutApi']);
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// register a user 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

// public Route
Route::apiResource('posts', PostController::class)
    ->only(['index', 'show']);

Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']);

Route::apiResource('posts.comments', CommentController::class)
    ->scoped()
    ->only(['index']);

// protected Route
Route::apiResource('posts', PostController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware('auth:sanctum');

Route::apiResource('categories', CategoryController::class)
    ->only(['store', 'destroy', 'update'])
    ->middleware('auth:sanctum');

Route::apiResource('posts.comments', CommentController::class)
    ->scoped()
    ->only(['store', 'update', 'destroy'])
    ->middleware('auth:sanctum');
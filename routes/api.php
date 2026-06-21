<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/auth', [UserController::class, 'auth']);

Route::get('/posts', [ArticleController::class, 'publicIndex']);
Route::get('/post/{article}', [ArticleController::class, 'publicShow']);
Route::get('/user/{user}/articles', [ArticleController::class, 'userArticles']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [UserController::class, 'logout']);
    
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::post('/article/add', [ArticleController::class, 'store']);
    Route::get('/article/{article}', [ArticleController::class, 'show']);
    Route::post('/article/edit/{article}', [ArticleController::class, 'update']);
    Route::get('/article/delete/{article}', [ArticleController::class, 'destroy']);
});
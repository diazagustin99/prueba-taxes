<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('users')->group(function () {
    Route::post('login', [UsersController::class, 'login']);
    Route::post('register', [UsersController::class, 'create']);
    Route::middleware('jwt.verify')->group(function () {
        Route::get('me', [UsersController::class, 'me']);
    });
});

Route::prefix('books')->group(function () {
    Route::get('all', [BooksController::class, 'index']);
    Route::get('search', [BooksController::class, 'search']);
    Route::middleware('jwt.verify')->group(function () {
        Route::post('register', [BooksController::class, 'create']);
        Route::post('update', [BooksController::class, 'update']);
        Route::post('delate', [BooksController::class, 'destroy']);
    });
});

Route::prefix('reviews')->group(function () {
    Route::get('all', [ReviewsController::class, 'index']);
    Route::get('show', [ReviewsController::class, 'show']);
    Route::middleware('jwt.verify')->group(function () {
        Route::post('register', [ReviewsController::class, 'store']);
        Route::post('update', [ReviewsController::class, 'update']);
        Route::post('delate', [ReviewsController::class, 'destroy']);
    });
});


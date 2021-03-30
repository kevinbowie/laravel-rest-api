<?php

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'users']);
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user/profile', [UserController::class, 'profile']);
    Route::get('user/{id}', [UserController::class, 'profileById']);
    Route::post('post', [PostController::class, 'store']);
    Route::put('post/{id}', [PostController::class, 'update']);
    Route::delete('post/{post}', [PostController::class, 'delete']);
});
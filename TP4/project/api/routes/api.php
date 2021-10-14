<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserFriendController;
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

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept, charset, boundary, Content-Length');
header('Access-Control-Allow-Origin: *');

Route::middleware(['customErrors', 'auth:sanctum'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('annonces', AnnonceController::class);
    Route::apiResource('groups', GroupController::class);
    Route::apiResource('users.friends', UserFriendController::class);
});

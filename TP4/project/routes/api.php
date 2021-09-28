<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
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

Route::get('/', function () {
    return [
        'data' => [],
        'meta' => [
            'success' => true,
            'message' => "",
        ]
    ];
});

Route::apiResource('users', UserController::class);
Route::apiResource('messages', MessageController::class);
Route::apiResource('annonces', AnnonceController::class);
Route::apiResource('friends', FriendController::class);
Route::apiResource('groups', GroupController::class);
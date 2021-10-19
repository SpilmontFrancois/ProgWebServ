<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserFriendController;
use App\Models\User;
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

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept, charset, boundary, Content-Length');
header('Access-Control-Allow-Origin: *');

Route::get('/login', function (Request $request) {
    return response()->json([
        'data' => [],
        'meta' => [
            'success' => false,
            'message' => "Unauthorized"
        ]
    ], 401);
})->name('login');

Route::post('/login', function (Request $request) {
    $data = $request->all();
    $login = $data['login'];
    $password = $data['password'];

    $user = User::where('login', $login)->first();
    $pass = $user->password;

    if ($user && password_verify($password, $pass)) {
        $token =  $user->createToken('api-access-token')->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token
            ],
            'meta' => [
                'success' => true,
                'message' => "Logged in"
            ]
        ], 200);
    } else {
        return response()->json([
            'data' => [],
            'meta' => [
                'success' => false,
                'message' => "Unauthorized"
            ]
        ], 401);
    }
});

Route::post('/register', function (Request $request) {
    $data = $request->all();

    $user = User::where('login', $data['login'])->first();
    if ($user) {
        return response()->json([
            'data' => [],
            'meta' => [
                'success' => false,
                'message' => "User already exists"
            ]
        ], 409);
    } else {
        $controller = new UserController;
        $controller->store($request);
        $user = User::where('login', $data['login'])->first();
        $token =  $user->createToken('api-access-token')->plainTextToken;
        return response()->json([
            'data' => [
                'token' => $token
            ],
            'meta' => [
                'success' => true,
                'message' => "Registered"
            ]
        ], 200);
    }
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('annonces', AnnonceController::class);
    Route::apiResource('groups', GroupController::class);
    Route::apiResource('users.friends', UserFriendController::class);
});

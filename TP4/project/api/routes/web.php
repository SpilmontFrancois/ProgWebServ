<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

    $user = User::where('login', $login)->where('password', $password)->first();
    if ($user) {
        $token =  $user->createToken('api-access-token')->plainTextToken;
        return response()->json([
            'data' => [],
            'meta' => [
                'success' => true,
                'message' => "Logged in",
                'token' => $token
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
            'data' => [],
            'meta' => [
                'success' => true,
                'message' => "Registered",
                'token' => $token
            ]
        ], 200);
    }
});

<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return UserResource::collection(User::simplePaginate($request->input('paginate') ?? 15));
    }

    public function show(int $id) {
        try {
            $user = User::findOrFail($id);
            return json_encode(new UserResource($user));
        } catch (Exception $e) {
            return json_encode('User does not exist.');
        }
    }
}

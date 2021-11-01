<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return UserResource::collection(User::simplePaginate($request->input('paginate') ?? 100));
    }

    public function show(int $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => "User does not exist."
                ]
            ], 404);
        }

        return response()->json([
            'data' => new UserResource($user),
            'meta' => [
                'success' => true,
                'message' => "User found"
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, ([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'login' => 'required|string',
            'password' => 'required|string',
            'coordinates' => 'required|string',
            'contaminated' => 'required|integer'
        ]));

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => "Wrongs inputs"
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'login' => $input['login'],
                'password' => password_hash($input['password'], PASSWORD_BCRYPT),
                'coordinates' => $input['coordinates'],
                'contaminated' => $input['contaminated']
            ]);
            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => $e->getMessage()
                ]
            ], 409);
        }

        return response()->json([
            'data' => [
                new UserResource($user)
            ],
            'meta' => [
                'success' => true,
                'message' => 'User created'
            ]
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $input = $request->all();

        try {
            $user = User::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'User does not exists'
                ]
            ], 404);
        }

        $validator = Validator::make($input, [
            'firstname' => 'sometimes|string',
            'lastname' => 'sometimes|string',
            'login' => 'sometimes|string',
            'coordinates' => 'sometimes|string',
            'contaminated' => 'sometimes|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => "Wrongs inputs"
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user->update($input);
            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => $e->getMessage()
                ]
            ], 409);
        }

        return response()->json([
            'data' => [
                new UserResource($user)
            ],
            'meta' => [
                'success' => true,
                'message' => 'User updated'
            ]
        ], 200);
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'meta' => [
                    'success' => false,
                    'message' => "User not found"
                ]
            ], 404);
        }

        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => $e->getMessage()
                ]
            ], 409);
        }

        return response()->json([
            'data' => [],
            'meta' => [
                'success' => true,
                'message' => 'User deleted'
            ]
        ], 200);
    }
}

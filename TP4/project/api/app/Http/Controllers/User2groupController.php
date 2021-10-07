<?php

namespace App\Http\Controllers;

use App\Http\Resources\User2groupResource;
use App\Models\User2group;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class User2groupController extends Controller
{
    public function index(Request $request)
    {
        return User2groupResource::collection(User2group::simplePaginate($request->input('paginate') ?? 15));
    }

    public function show(int $id)
    {
        try {
            $User2group = User2group::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => "User2group does not exist."
                ]
            ], 404);
        }

        return response()->json([
            'data' => new User2groupResource($User2group),
            'meta' => [
                'success' => true,
                'message' => "User2group found"
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, ([
            'user_id' => 'required|integer',
            'group_id' => 'required|integer',
            'isAdmin' => 'required|integer'
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
            $User2group = User2group::create($input);
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
                new User2groupResource($User2group)
            ],
            'meta' => [
                'success' => true,
                'message' => 'User2group created'
            ]
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $input = $request->all();

        try {
            $User2group = User2group::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'User2group does not exists'
                ]
            ], 404);
        }

        $validator = Validator::make($input, [
            'user_id' => 'required|integer',
            'group_id' => 'required|integer',
            'isAdmin' => 'required|integer'
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
            $User2group->update($input);
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
                new User2groupResource($User2group)
            ],
            'meta' => [
                'success' => true,
                'message' => 'User2group updated'
            ]
        ], 200);
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $User2group = User2group::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'meta' => [
                    'success' => false,
                    'message' => "User2group not found"
                ]
            ], 404);
        }

        DB::beginTransaction();
        try {
            $User2group->delete();
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
                'message' => 'User2group deleted'
            ]
        ], 200);
    }
}

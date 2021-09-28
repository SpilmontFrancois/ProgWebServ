<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendResource;
use App\Models\Friend;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class FriendController extends Controller
{
    public function index(Request $request)
    {
        return FriendResource::collection(Friend::simplePaginate($request->input('paginate') ?? 15));
    }

    public function show(int $id1, int $id2)
    {
        // WIP : trouver comment passer 2 ids
        try {
            print_r($id1, $id2);
            $friend = Friend::findOrFail($id1);
            return response()->json([
                'data' => new FriendResource($friend),
                'meta' => [
                    'success' => true,
                    'message' => 'friends found'
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'friends does not exist'
                ]
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, ([
            'user1' => 'required|integer',
            'user2' => 'required|integer'
        ]));

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'Wrong inputs'
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
            $friend = Friend::create($input);
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
            'data' => new FriendResource($friend),
            'meta' => [
                'success' => true,
                'message' => 'friends created'
            ]
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $friend = Friend::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'meta' => [
                    'success' => false,
                    'message' => "Wrongs inputs"
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
            $friend->delete();
            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'code' => 409
                ]
            ], 409);
        }

        return response()->json([
            'data' => [],
            'meta' => [
                'success' => true,
                'message' => 'friend deleted'
            ]
        ], 200);
    }
}

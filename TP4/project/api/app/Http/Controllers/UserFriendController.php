<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendResource;
use App\Models\Friend;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class UserFriendController extends Controller
{
    public function index(Request $request, User $user)
    {
        return FriendResource::collection(Friend::simplePaginate($request->input('paginate') ?? 15));
    }

    public function show(User $user, int $friend)
    {
        try {
            $friend = Friend::where('user1', $user->id)->orWhere('user2', $user->id)->where('user1', $friend)->orWhere('user2', $friend)->first();
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'friend does not exist'
                ]
            ], 404);
        }
        
        return response()->json([
            'data' => new FriendResource($friend),
            'meta' => [
                'success' => true,
                'message' => 'friend found'
            ]
        ], 200);
    }

    public function store(Request $request, User $user)
    {
        $input = $request->all();

        $validator = Validator::make($input, ([
            'user1' => 'required|string',
            'user2' => 'required|string'
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

    public function destroy(Request $request, User $user, int $friend)
    {
        try {
            $friend = Friend::where('user1', $user->id)->orWhere('user2', $user->id)->where('user1', $friend)->orWhere('user2', $friend)->first();
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

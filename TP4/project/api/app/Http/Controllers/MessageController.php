<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class MessageController extends Controller
{
    public function index(Request $request)
    {
        return MessageResource::collection(Message::simplePaginate($request->input('paginate') ?? 15));
    }

    public function show(int $id)
    {
        try {
            $message = Message::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'Message does not exist'
                ]
            ], 404);
        }
        
        return response()->json([
            'data' => new MessageResource($message),
            'meta' => [
                'success' => true,
                'message' => 'Message found'
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, ([
            'user1' => 'required|string',
            'user2' => 'required|string',
            'content' => 'required|string'
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
            $message = Message::create($input);
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
            'data' => new MessageResource($message),
            'meta' => [
                'success' => true,
                'message' => 'Message created'
            ]
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $input = $request->all();

        try {
            $message = Message::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'Message does not exists'
                ]
            ], 404);
        }

        $validator = Validator::make($input, [
            'user1' => 'sometimes|string',
            'user2' => 'sometimes|string',
            'content' => 'sometimes|string'
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
            $message->update($input);
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
                new MessageResource($message)
            ],
            'meta' => [
                'success' => true,
                'message' => 'Message updated'
            ]
        ], 200);
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $message = Message::findOrFail($id);
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
            $message->delete();
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
                'message' => 'Message deleted'
            ]
        ], 200);
    }
}

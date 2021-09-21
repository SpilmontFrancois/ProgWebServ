<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        return MessageResource::collection(Message::simplePaginate($request->input('paginate') ?? 15));
    }

    public function show(int $id) {
        try {
            $message = Message::findOrFail($id);
            return json_encode(new MessageResource($message));
        } catch (Exception $e) {
            return json_encode('Message does not exist.');
        }
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
            return [
                'meta' => [
                    'success' => false,
                    'message' => "Wrongs inputs",
                    'code' => 422
                ]
            ];
        }

        DB::beginTransaction();
        try {
            $user = User::create($input);
            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return [
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'code' => 409
                ]
            ];
        }

        return [
            'data' => [
                new UserResource($user)
            ],
            'meta' => [
                'success' => true,
                'message' => 'User created',
                'code' => 201
            ]
        ];
    }

    public function update(Request $request, int $id)
    {
        $input = $request->all();

        try {
            $user = User::findOrFail($id);
        } catch (Exception $e) {
            return [
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'User does not exists',
                    'code' => 404
                ]
            ];
        }

        $validator = Validator::make($input, [
            'firstname' => 'sometimes|string',
            'lastname' => 'sometimes|string',
            'login' => 'sometimes|string',
            'password' => 'sometimes|string',
            'coordinates' => 'sometimes|string',
            'contaminated' => 'sometimes|integer'
        ]);

        if ($validator->fails()) {
            return [
                'meta' => [
                    'success' => false,
                    'message' => "Wrongs inputs",
                    'code' => 422
                ]
            ];
        }

        DB::beginTransaction();
        try {
            $user->update($input);
            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return [
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'code' => 409
                ]
            ];
        }

        return [
            'data' => [
                new UserResource($user)
            ],
            'meta' => [
                'success' => true,
                'message' => 'User updated',
                'code' => 200
            ]
        ];
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (Exception $e) {
            return [
                'data' => $e->getMessage(),
                'meta' => [
                    'success' => false,
                    'message' => "Wrongs inputs",
                    'code' => 422
                ]
            ];
        }

        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return [
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'code' => 409
                ]
            ];
        }

        return [
            'data' => [],
            'meta' => [
                'success' => true,
                'message' => 'User deleted',
                'code' => 200
            ]
        ];
    }
}

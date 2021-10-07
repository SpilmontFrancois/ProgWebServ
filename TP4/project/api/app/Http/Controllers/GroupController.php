<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        return GroupResource::collection(Group::simplePaginate($request->input('paginate') ?? 15));
    }

    public function show(int $id)
    {
        try {
            $group = Group::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => "Group does not exist."
                ]
            ], 404);
        }

        return response()->json([
            'data' => new GroupResource($group),
            'meta' => [
                'success' => true,
                'message' => "Group found"
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, ([
            'name' => 'required|string'
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
            $group = Group::create($input);
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
                new GroupResource($group)
            ],
            'meta' => [
                'success' => true,
                'message' => 'Group created'
            ]
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $input = $request->all();

        try {
            $group = Group::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'Group does not exists'
                ]
            ], 404);
        }

        $validator = Validator::make($input, [
            'name' => 'sometimes|string'
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
            $group->update($input);
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
                new GroupResource($group)
            ],
            'meta' => [
                'success' => true,
                'message' => 'Group updated'
            ]
        ], 200);
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $group = Group::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'meta' => [
                    'success' => false,
                    'message' => "Group not found"
                ]
            ], 404);
        }

        DB::beginTransaction();
        try {
            $group->delete();
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
                'message' => 'Group deleted'
            ]
        ], 200);
    }
}

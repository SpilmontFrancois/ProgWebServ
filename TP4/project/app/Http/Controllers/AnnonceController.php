<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnnonceResource;
use App\Models\Annonce;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        return AnnonceResource::collection(Annonce::simplePaginate($request->input('paginate') ?? 15));
    }

    public function show(int $id)
    {
        try {
            $Annonce = Annonce::findOrFail($id);
            return response()->json([
                'data' => new AnnonceResource($Annonce),
                'meta' => [
                    'success' => true,
                    'message' => "Annonce found"
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => "Annonce does not exist."
                ]
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, ([
            'group_id' => 'sometimes|integer',
            'user' => 'sometimes|integer',
            'content' => 'sometimes|string'
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
            $Annonce = Annonce::create($input);
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
                new AnnonceResource($Annonce)
            ],
            'meta' => [
                'success' => true,
                'message' => 'Annonce created'
            ]
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $input = $request->all();

        try {
            $Annonce = Annonce::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'success' => false,
                    'message' => 'Annonce does not exists'
                ]
            ], 404);
        }

        $validator = Validator::make($input, [
            'group_id' => 'sometimes|integer',
            'user' => 'sometimes|integer',
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
            $Annonce->update($input);
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
                new AnnonceResource($Annonce)
            ],
            'meta' => [
                'success' => true,
                'message' => 'Annonce updated'
            ]
        ], 200);
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $Annonce = Annonce::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e->getMessage(),
                'meta' => [
                    'success' => false,
                    'message' => "Annonce not found"
                ]
            ], 404);
        }

        DB::beginTransaction();
        try {
            $Annonce->delete();
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
                'message' => 'Annonce deleted'
            ]
        ], 200);
    }
}

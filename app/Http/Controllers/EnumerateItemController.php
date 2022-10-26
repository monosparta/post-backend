<?php

namespace App\Http\Controllers;

use App\Models\Enumerate;
use Illuminate\Http\Request;
use App\Models\EnumerateItem;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EnumerateResource;
use App\Http\Resources\EnumerateItemResource;

class EnumerateItemController extends Controller
{
    /* #region set Enumerate default value */
    /**
     * Set Enumerate default value
     * @OA\PATCH(
     *     tags={"EnumerateItem"},
     *     path="/api/enumerateItems/{enumerateItem}/default",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="enumerateItem",
     *         description="EnumerateItem ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=406, description="Only Accept application/json"),
     * )
     * @param  \App\Models\EnumerateItem  $enumerateItem
     * @return \Illuminate\Http\JsonResponse
     */
    /* #endregion */
    public function defaultValue(EnumerateItem $enumerateItem) : JsonResponse
    {
        $enumerate = $enumerateItem->enumerate;
        $enumerate->default_value = $enumerateItem->value;
        $enumerate->save();

        return response()->json(EnumerateResource::make($enumerate)
            ->additional(['meta' =>[
                'default_enumerate_item_id' => $enumerateItem->id,
            ]])->response()->getData(true));
    }

    /* #region up Enumerate Item sequence value */
    /**
     * Up Enumerate Item sequence value 
     * @OA\Patch(
     *     tags={"EnumerateItem"},
     *     path="/api/enumerateItems/{enumerateItem}/sequence/up",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="enumerateItem",
     *         description="EnumerateItem ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=406, description="Only Accept application/json"),
     * )
     * @param  \App\Models\EnumerateItem  $enumerateItem
     * @return \Illuminate\Http\JsonResponse
     */
    /* #endregion */
    public function upSequence(EnumerateItem $enumerateItem) : JsonResponse
    {
        $currentSequence = $enumerateItem->sequence;
        $previousItem = $enumerateItem->enumerate->enumerateItems()->where('sequence', '=', $currentSequence - 1)->first();
        if (!$previousItem) {
            return response()->json([
                'message' => 'is already the first item',
            ]);
        }
        \DB::transaction(function () use ($enumerateItem, $previousItem) {
            $previousItem->sequence = $enumerateItem->sequence;
            $previousItem->save();
            $enumerateItem->upSequence();
        });

        return response()->json([
            'current' => new EnumerateItemResource($enumerateItem),
            'next' => new EnumerateItemResource($previousItem),
        ]);
    }

    /* #region down Enumerate Item sequence value */
    /**
     * Down Enumerate Item sequence value
     * @OA\Patch(
     *      tags={"EnumerateItem"},
     *      path="/api/enumerateItems/{enumerateItem}/sequence/down",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="enumerateItem",
     *          description="EnumerateItem ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Not Found"),
     *      @OA\Response(response=406, description="Only Accept application/json"),
     * )
     * @param  \App\Models\EnumerateItem  $enumerateItem
     * @return \Illuminate\Http\JsonResponse
     */
    /* #endregion */
    public function downSequence(EnumerateItem $enumerateItem) : JsonResponse
    {
        $currentSequence = $enumerateItem->sequence;
        $nextItem = $enumerateItem->enumerate->enumerateItems()->where('sequence', '=', $currentSequence + 1)->first();
        if (!$nextItem) {
            return response()->json([
                'message' => 'is already the last item',
            ]);
        }
        \DB::transaction(function () use ($enumerateItem, $nextItem) {
            $nextItem->sequence = $enumerateItem->sequence;
            $nextItem->save();
            $enumerateItem->downSequence();
        });

        return response()->json([
            'current' => new EnumerateItemResource($enumerateItem),
            'previous' => new EnumerateItemResource($nextItem),
        ]);
    }
}

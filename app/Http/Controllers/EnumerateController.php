<?php

namespace App\Http\Controllers;

use App\Models\Enumerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DropDownUrlResource;
use App\Http\Resources\DropDownItemResource;

class EnumerateController extends Controller
{
    /* #region find all enumerate name and url */
    /**
     * Display all enumerate name and url.
     * @OA\Get(
     *     tags={"Enumerate Dropdown"},
     *     path="/api/enumerate/url",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     * )

     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function getEnumerateUrl()
    {
        return response()->json(DropDownUrlResource::collection(Enumerate::select('name')->where('is_enabled', true)->get()));
    }

    /* #region drop down enumerate by enumerate name */
    /**
     * Drop down enumerate by enumerate name.
     * @OA\Get(
     *     tags={"Enumerate Dropdown"},
     *     path="/api/enumerate/{enumerateName}/items",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="enumerateName",
     *         description="Enumerate Name",
     *         required=true,
     *         example="cities",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     * )

     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function dropDown($enumerateItemName)
    {
        $enumerate = Enumerate::where('name', $enumerateItemName)->where('is_enabled', true)->firstOrFail();
        $enumerateItems = $enumerate->enumerateItems()->get();
        $response = DropDownItemResource::collection($enumerateItems);
        return response()->json($response);
    }
}

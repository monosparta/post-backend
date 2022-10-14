<?php

namespace App\Http\Controllers;

use App\Models\UserCategory;
use Illuminate\Http\Request;
use App\Http\Resources\UserCategoryResource;
use App\Http\Requests\StoreUserCategoryRequest;
use App\Http\Requests\UpdateUserCategoryRequest;

class UserCategoryController extends Controller
{
    /* #region get user categories */
    /**
     * Display all users categories.
     *  @OA\Get(
     *      path="/api/userCategories",
     *      tags={"UserCategory"},
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent()
     *      ),
     *  )
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function index()
    {
        $userCategories = UserCategory::all();
        return response()->json(UserCategoryResource::collection($userCategories));
    }

    /* #region get user categories */
    /**
     * Datatable categories.
     *  @OA\POST(
     *      path="/api/userCategories/index",
     *      tags={"UserCategory"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/FilterServiceParams")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent()
     *      ),
     *  )
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function datatable(Request $request)
    {
        $filters = $request->input('filters');
        $sorts = $request->input('sorts');
        $pageSize = $request->input('pageSize');

        $data = UserCategory::datatable($filters, $sorts, $pageSize);

        $result = [
            'items' => UserCategoryResource::collection($data->items()),
            'total' => $data->total(),
        ];
        return response()->json($result);
    }

    /* #region create new user category */
    /**
     * Create new user category.
     *  @OA\POST(
     *      path="/api/userCategories",
     *      tags={"UserCategory"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(property="name", type="string", default="test"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=201, description="Created", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=422, description="Unprocessable Content"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function store(StoreUserCategoryRequest $request)
    {
        $data = $request->validated();
        $userCategory = UserCategory::create($data);
        return response()->json(new UserCategoryResource($userCategory));
    }

    /* #region find user category */
    /**
     * Display Category
     * @OA\Get(
     *     tags={"UserCategory"},
     *     path="/api/userCategories/{userCategory}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="userCategory",
     *         description="UserCategory ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     * )

     * @param  \App\Models\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function show(UserCategory $userCategory)
    {
        return response()->json(new UserCategoryResource($userCategory));
    }

    /* #region update user category */
    /**
     * Update the User Category name.
     * @OA\Put(
     *     tags={"UserCategory"},
     *     path="/api/userCategories/{userCategory}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="userCategory",
     *         description="UserCategory ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(property="name", type="string", default=""),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=204, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=422, description="Unprocessable Content"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function update(UpdateUserCategoryRequest $request, UserCategory $userCategory)
    {
        $date = $request->validated();
        $userCategory->update($date);
        return response()->json(new UserCategoryResource($userCategory));
    }

    /* #region delete user category */
    /**
     * Remove User Category.
     * @OA\Delete(
     *     tags={"UserCategory"},
     *     path="/api/userCategories/{userCategory}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="userCategory",
     *         description="UserCategory ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=204, description="No Content", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=406, description="Only Accept application/json"),
     * )
     * @param  \App\Models\UserCategory  $userCategory
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function destroy(UserCategory $userCategory)
    {
        $userCategory->delete();
        return response()->noContent();
    }
}

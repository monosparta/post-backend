<?php

namespace App\Http\Controllers;

use App\Models\UserCategory;
use Illuminate\Http\Request;
use App\Http\Resources\UserCategoryResource;

class UserCategoryController extends Controller
{
    /* #region get user categories */
    /**
     * Display all users categories.
     *  @OA\Get(
     *      path="/api/users/categories",
     *      parameters={
     *         @OA\Parameter(
     *            name="paginate",
     *            in="query",
     *            description="Number of users per page, default is 10",
     *            required=false,
     *            example="10"
     *            ),
     *        @OA\Parameter(
     *           name="filter",
     *           in="query",
     *           description="Filter userCategory by type name",
     *           required=false,
     *           example=""
     *           ),
     *      },
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
    public function index(Request $request)
    {
        $filter = $request->filter ? $request->filter : null;
        $userCategories = UserCategory::when($filter, function ($query, $filter) {
            return $query->where('name', 'like', '%' . $filter . '%');
        });

        if ($request->has('paginate') && $request->paginate != null) {
            $paginate= $request->paginate ? intval($request->paginate, 10) : 10;
            $userCategories = $userCategories->paginate($paginate);
            $userCategories = UserCategoryResource::collection($userCategories)->response()->getData(true);
        } else {
            $userCategories = $userCategories->get();
            $userCategories = UserCategoryResource::collection($userCategories);
        }
        return response()->json($userCategories);
    }
    /* #region create new user category */
    /**
     * Create new user category.
     *  @OA\POST(
     *      path="/api/users/categories",
     *      tags={"UserCategory"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(property="name", type="string", default=""),
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $userCategory = UserCategory::create([
            'name' => $request->name,
        ]);
        return new UserCategoryResource($userCategory);
    }

    /* #region find user category */
    /**
     * Display Category
     * @OA\Get(
     *     tags={"UserCategory"},
     *     path="/api/users/categories/{id}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
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

     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function show($id)
    {
        $userCategory = UserCategory::findOrFail($id);
        return new UserCategoryResource($userCategory);
    }

    /* #region update user category */
    /**
     * Update the User Category name.
     * @OA\Put(
     *     tags={"UserCategory"},
     *     path="/api/users/categories/{id}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $userCategory = UserCategory::findOrFail($id);
        $userCategory->update([
            'name' => $request->name,
        ]);
        return new UserCategoryResource($userCategory);
    }

    /* #region delete user category */
    /**
     * Remove User Category.
     * @OA\Delete(
     *     tags={"UserCategory"},
     *     path="/api/users/categories/{id}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function destroy($id)
    {
        $userCategory = UserCategory::findOrFail($id);
        $userCategory->delete();
        return response()->noContent();
    }
}

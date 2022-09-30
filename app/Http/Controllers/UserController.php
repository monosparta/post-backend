<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserListResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserInfoResource;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\EmergencyContactsResource;
use App\Http\Requests\StoreOrUpdateUserProfileRequest;
use App\Http\Requests\StoreOrUpdateUserOrganizationRequest;
use App\Http\Requests\StoreOrUpdateUserEmergencyContactRequest;

class UserController extends Controller
{
    /* #region get user */
    /**
     * Paginate all users
     *  @OA\Get(
     *      path="/api/users",
     *      parameters={
     *         @OA\Parameter(
     *            name="paginate",
     *            in="query",
     *            description="Number of users per page",
     *            required=false,
     *            example="10"
     *            ),
     *        @OA\Parameter(
     *           name="filter",
     *           in="query",
     *           description="Filter users by name or email or mobile",
     *           required=false,
     *           example=""
     *           ),
     *      },
     *      tags={"Users"},
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="success", @OA\JsonContent())
     *  )
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function index(Request $request)
    {
        $paginate= $request->paginate ? intval($request->paginate, 10) : 10;
        $filter = $request->filter ? $request->filter : '';
        if ($filter) {
            $users = User::where('name', 'like', '%' . $filter . '%')
                ->orWhere('email', 'like', '%' . $filter . '%')
                ->orWhere('mobile', 'like', '%' . $filter . '%')
                ->paginate($paginate);
        } else {
            $users = User::paginate($paginate);
        }
        $users = UserListResource::collection($users)->response()->getData(true);

        return response()->json($users);
    }
    /* #region create user */
    /**
     * Create a new user
     *  @OA\POST(
     *      path="/api/users",
     *      tags={"Users"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(property="custom_id", type="string", default="7E0001"),
     *                  @OA\Property(property="username", type="string", default="test01"),
     *                  @OA\Property(property="full_name", type="string", default="test01"),
     *                  @OA\Property(property="email", type="string", default="test01@example.com"),
     *                  @OA\Property(property="mobile_country_code", type="string", default="TW"),
     *                  @OA\Property(property="mobile_country_calling_code", type="string", default="+886"),
     *                  @OA\Property(property="mobile", type="string", default="905123456"),
     *                  @OA\Property(property="password", type="password", default="password"),
     *                  @OA\Property(property="confirm_password", type="password", default="password"),
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
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'custom_id' => $request->validated()['custom_id'],
            'name' => $request->validated()['username'],
            'email' => $request->validated()['email'],
            'full_name' => $request->validated()['full_name'],
            'mobile_country_code' => $request->validated()['mobile_country_code'],
            'mobile_country_calling_code' => $request->validated()['mobile_country_calling_code'],
            'mobile' => $request->validated()['mobile'],
            'password' => Hash::make($request->validated()['password']),
        ]);

        return response()->json(new UserInfoResource($user), 201);
    }
    /* #region find user */
    /**
     * Display User by user id
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/users/{id}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         description="User ID",
     *         required=true,
     *         example="ffffffff-ffff-ffff-ffff-ffffffffffff",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     * )

     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function show($id)
    {
        $user = User::with('profile')->with('profile.address')->with('emergencyContacts')->with('organization')->with('userCategories')->findOrFail($id);

        // return response()->json($user);
        return response()->json(new UserDetailResource($user));
    }
    /* #region update user */
    /**
     * Update User info by user id
     * @OA\Put(
     *     tags={"Users"},
     *     path="/api/users/{id}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         description="User ID",
     *         required=true,
     *         example="ffffffff-ffff-ffff-ffff-ffffffffffff",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(property="username", type="string", default="test"),
     *                  @OA\Property(property="email", type="string", default="test@example.com"),
     *                  @OA\Property(property="full_name", type="string", default="Test"),
     *                  @OA\Property(property="mobile_country_code", type="string", default="TW"),
     *                  @OA\Property(property="mobile_country_calling_code", type="string", default="+886"),
     *                  @OA\Property(property="mobile", type="string", default="905123456"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=204, description="OK", @OA\JsonContent()),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function update(UpdateUserRequest $request, $id)
    {
        if ($request->exists('password')) {
            $request['password'] = $request->validated()['password'];
        }

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->validated()['username'],
            'email' => $request->validated()['email'],
            'full_name' => $request->validated()['full_name'],
            'mobile_country_code' => $request->validated()['mobile_country_code'],
            'mobile_country_calling_code' => $request->validated()['mobile_country_calling_code'],
            'mobile' => $request->validated()['mobile'],
        ]);

        return response()->json(new UserInfoResource($user), 200);
    }
    /* #region delete user */
    /**
     * Delete User by user id
     * @OA\Delete(
     *     tags={"Users"},
     *     path="/api/users/{id}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         description="User ID",
     *         required=true,
     *         example="ffffffff-ffff-ffff-ffff-ffffffffffff",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=204, description="No Content", @OA\JsonContent()),
     * )
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    /* #region store user profile */
    /**
     * Create/Update the User profile by user id
     * @OA\POST(
     *     tags={"Users"},
     *     path="/api/users/{id}/profile",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         description="User ID",
     *         required=true,
     *         example="ffffffff-ffff-ffff-ffff-ffffffffffff",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(property="categories", type="object",
     *                      @OA\Property(property="id", type="number", default=4),
     *                  ),
     *                  @OA\Property(property="first_name", type="string", default="Test"),
     *                  @OA\Property(property="last_name", type="string", default="Test"),
     *                  @OA\Property(property="middle_name", type="string", default="Test"),
     *                  @OA\Property(property="birth_date", type="string", default="1998-01-01"),
     *                  @OA\Property(property="gender", type="string", default="male"),
     *                  @OA\Property(property="job_title", type="string", default="engineer"),
     *                  @OA\Property(property="phone_country_code", type="string", default="TW"),
     *                  @OA\Property(property="phone_country_calling_code", type="string", default="+886"),
     *                  @OA\Property(property="phone", type="string", default="0422010000"),
     *                  @OA\Property(property="nationality", type="string", default="中華民國"),
     *                  @OA\Property(property="identity_code", type="string", default="N121111111"),
     *                  @OA\Property(property="address", type="object", 
     *                      @OA\Property(property="city", type="string", default="台中市"),
     *                      @OA\Property(property="region", type="string", default="西區"),
     *                      @OA\Property(property="zip_code", type="string", default="403"),
     *                      @OA\Property(property="address_line_1", type="string", default="台灣大道一段"),
     *                      @OA\Property(property="address_line_2", type="string", default=""),
     *                  ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=422, description="Unprocessable Content"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    /* #endregion */
    public function profile(StoreOrUpdateUserProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->exists('categories')) {
            $userCategories = UserCategory::where('id', $request->categories['id'])->first();
            if (! $userCategories) {
                return response()->json(['success' => false, 'message' => 'User Category not found'], 404);
            }
            $user->userCategories()->sync($userCategories->id);
        }

        $user->profile()->updateOrCreate(['user_id' => $id], $request->validated());

        if ($request->validated(['address'])) {
            if($user->profile->address()->exists()){
                $user->profile->address()->update($request->validated(['address']));
            } else {
                $user->profile->address()->create($request->validated(['address']));
            }
        }

        return response()->json(new UserProfileResource($user), 200);
    }

    /* #region store user organization */
    /**
     * Create/Update the User Organization by user id
     * @OA\POST(
     *     tags={"Users"},
     *     path="/api/users/{id}/organization",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         description="User ID",
     *         required=true,
     *         example="ffffffff-ffff-ffff-ffff-ffffffffffff",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(property="name", type="string", default="測試股份有限公司"),
     *                  @OA\Property(property="vat", type="string", default="0000000"),
     *                  @OA\Property(property="phone_country_code", type="string", default="TW"),
     *                  @OA\Property(property="phone_country_calling_code", type="string", default="+886"),
     *                  @OA\Property(property="phone", type="string", default="0422000000"),
     *                  @OA\Property(property="email", type="string", default="test@example.com"),
     *                  @OA\Property(property="address", type="object", 
     *                      @OA\Property(property="city", type="string", default="台中市"),
     *                      @OA\Property(property="region", type="string", default="西區"),
     *                      @OA\Property(property="zip_code", type="string", default="403"),
     *                      @OA\Property(property="address_line_1", type="string", default="台灣大道一段"),
     *                      @OA\Property(property="address_line_2", type="string", default=""),
     *                  ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=422, description="Unprocessable Content"),
     *     @OA\Response(response=406, description="Only Accept application/json"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function organization(StoreOrUpdateUserOrganizationRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->organization()->updateOrCreate(['user_id' => $id], $request->validated());

    if ($request->validated(['address'])) {
        if ($user->organization->address()->exists()) {
            $user->organization->address()->update($request->validated(['address']));
        } else {
            $user->organization->address()->create($request->validated(['address']));
        }
    }

        return response()->json(new OrganizationResource($user->organization), 200);
    }

    /* #region store user emergency contact */
    /**
     * Create/Update the User Emergency Contact by user id
     * @OA\POST(
     *     tags={"Users"},
     *     path="/api/users/{id}/emergency-contact",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         description="User ID",
     *         required=true,
     *         example="ffffffff-ffff-ffff-ffff-ffffffffffff",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(property="name", type="string", default="測試"),
     *                  @OA\Property(property="mobile_country_code", type="string", default="TW"),
     *                  @OA\Property(property="mobile_country_calling_code", type="string", default="+886"),
     *                  @OA\Property(property="mobile", type="string", default="905000000"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
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
    public function emergencyContact(StoreOrUpdateUserEmergencyContactRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if($user->emergencyContacts()->exists()) {
            $user->emergencyContacts()->update($request->validated());
        } else {
            $user->emergencyContacts()->create($request->validated());
        }
        return response()->json(new EmergencyContactsResource($user->emergencyContacts[0]), 200);
    }
}

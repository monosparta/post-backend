<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserInfoResource;
use App\Http\Resources\UserListResource;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\EmergencyContactsResource;
use App\Http\Requests\StoreOrUpdateUserNoteRequest;
use App\Http\Requests\StoreOrUpdateUserProfileRequest;
use App\Http\Requests\StoreOrUpdateUserOrganizationRequest;
use App\Http\Requests\StoreOrUpdateUserEmergencyContactRequest;

class UserController extends Controller
{
    /* #region get user */
    /**
     * get 10 user
     *  @OA\Get(
     *      path="/api/users",
     *      tags={"Users"},
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="success", @OA\JsonContent())
     *  )
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function index()
    {
        $data = User::paginate(10);

        $result = [
            'items' => UserListResource::collection($data->items()),
            'total' => $data->total(),
        ];

        return response()->json($result);
    }

    /* #region datatable user */
    /**
     * datatable for users
     *  @OA\POST(
     *      path="/api/users/index",
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/FilterServiceParams")
     *      ),
     *      tags={"Users"},
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="success", @OA\JsonContent())
     *  )
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function datatable(Request $request)
    {
        $filters = $request->input('filters');
        $sorts = $request->input('sorts');
        $pageSize = $request->input('pageSize');

        $data = User::datatable($filters, $sorts, $pageSize);

        $result = [
            'items' => UserListResource::collection($data->items()),
            'total' => $data->total(),
        ];
        return response()->json($result);
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
        $data = $request->validated();
        $username = $data['username'];
        $user = User::create([...$data, 'name' => $username]);
        return response()->json(new UserInfoResource($user), 201);
    }
    /* #region find user */
    /**
     * Display User by user id
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/users/{user}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="user",
     *         description="User ID",
     *         required=true,
     *         example="ffffffff-ffff-ffff-ffff-ffffffffffff",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent()),
     * )

     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function show(User $user)
    {
        return response()->json(new UserDetailResource($user));
    }

    /* #region update user */
    /**
     * Update User info by user id
     * @OA\Put(
     *     tags={"Users"},
     *     path="/api/users/{user}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="user",
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $username = $data['username'];
        $user->update([...$data, 'name' => $username]);
        return response()->json(new UserInfoResource($user), 200);
    }

    /* #region delete user */
    /**
     * Delete User by user id
     * @OA\Delete(
     *     tags={"Users"},
     *     path="/api/users/{user}",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="user",
     *         description="User ID",
     *         required=true,
     *         example="ffffffff-ffff-ffff-ffff-ffffffffffff",
     *         in="path",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(response=204, description="No Content", @OA\JsonContent()),
     * )
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    /* #region store user profile */
    /**
     * Create/Update the User profile by user id
     * @OA\POST(
     *     tags={"Users"},
     *     path="/api/users/{user}/profile",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="user",
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    /* #endregion */
    public function profile(StoreOrUpdateUserProfileRequest $request, User $user)
    {
        $data = $request->validated();

        if ($data['categories']) {
            $userCategory = UserCategory::findOrFail($data['categories']['id']);
            $userCategory = $user->userCategories()->sync($userCategory);
        }

        $user->profile()->updateOrCreate(['user_id' => $user->id], $data);

        if($data['address']) {
            if ($user->profile->address()->exists()) {
                $user->profile->address()->update($data['address']);
            } else {
                $user->profile->address()->create($data['address']);
            }
        }

        return response()->json(new UserProfileResource($user), 200);
    }

    /* #region store user organization */
    /**
     * Create/Update the User Organization by user id
     * @OA\POST(
     *     tags={"Users"},
     *     path="/api/users/{user}/organization",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="user",
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function organization(StoreOrUpdateUserOrganizationRequest $request, User $user)
    {
        $data = $request->validated();
        $user->organization()->updateOrCreate(['user_id' => $user->id], $data);

        if ($data['address']) {
            if ($user->organization->address()->exists()) {
                $user->organization->address()->update($data['address']);
            } else {
                $user->organization->address()->create($data['address']);
            }
        }

        return response()->json(new OrganizationResource($user->organization), 200);
    }

    /* #region store user emergency contact */
    /**
     * Create/Update the User Emergency Contact by user id
     * @OA\POST(
     *     tags={"Users"},
     *     path="/api/users/{user}/emergency-contact",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="user",
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function emergencyContact(StoreOrUpdateUserEmergencyContactRequest $request, User $user)
    {
        $data = $request->validated();
        if($user->emergencyContacts()->exists()) {
            $user->emergencyContacts()->update($data);
        } else {
            $user->emergencyContacts()->create($data);
        }
        return response()->json(new EmergencyContactsResource($user->emergencyContacts[0]), 200);
    }


    /* #region store user note */
    /**
     * Create/Update the User Note by user id
     * @OA\POST(
     *     tags={"Users"},
     *     path="/api/users/{user}/note",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="user",
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
     *                  @OA\Property(property="note", type="string", default="測試"),
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
     * @param  App\Http\Requests\StoreOrUpdateUserNoteRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function note(StoreOrUpdateUserNoteRequest $request, User $user)
    {
        $data = $request->validated();
        $user->profile()->updateOrCreate(['user_id' => $user->id], $data);
        return response()->json(['note' => $user->profile->note], 200);
    }
}

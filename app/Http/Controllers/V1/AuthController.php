<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /* #region Auth register */
    /**
     * register by email and password
     *
     *  @OA\POST(
     *      path="/api/v1/register",
     *      tags={"V1/Auth"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(property="email", type="string", default="test@example.com"),
     *                  @OA\Property(property="password", type="password", default="password"),
     *                  @OA\Property(property="confirm_password", type="password", default="password"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=201, description="Register success", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    /* #endregion */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'confirm_password' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 401);
        }

        $request['name'] = explode('@', $request['email'])[0];

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        $accessToken = $user->createAuthToken('auth');
        $refreshToken = $user->createRefreshToken('refresh');

        $response = [
            'message' => 'Successfully register!',
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];

        return response(new AuthResource($response), 201);
    }

    /* #region Auth login */
    /**
     * login by email and password
     *
     *  @OA\POST(
     *      path="/api/v1/login",
     *      tags={"V1/Auth"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *               @OA\Schema(
     *                  @OA\Property(property="email", type="string", default="test@example.com"),
     *                  @OA\Property(property="password", type="password", default="password"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response=200, description="Login success", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    /* #endregion */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = $request->user();
        $accessToken = $user->createAuthToken('auth');
        $refreshToken = $user->createRefreshToken('refresh');

        $response = [
            'message' => 'Successfully login in!',
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];

        return response(new AuthResource($response), 200);
    }

    /* #region Clean user all token by access token */
    /**
     * Clean user all token by access token
     *
     *  @OA\POST(
     *      path="/api/v1/token-clear",
     *      tags={"V1/Auth"},
     *      security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Login success", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function cleanToken(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()->json([
            'message' => 'Successfully logged out all devices!',
        ]);
    }

    /* #region use refresh token return new access token */
    /**
     * use refresh token return new access token, and clean old access token, need Bearer refresh token
     *
     *  @OA\Get(
     *      path="/api/v1/refresh-token",
     *      tags={"V1/Auth"},
     *      security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Login success", @OA\JsonContent()),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /* #endregion */
    public function refreshToken(): JsonResponse
    {
        $user = Auth::user();

        $user->tokens()->where('name', 'auth')->delete();
        $user->tokens()->where('name', 'refresh')->delete();

        $accessToken = $user->createAuthToken('auth');
        $refreshToken = $user->createRefreshToken('refresh');

        $response = [
            'token' => [
                'access_token' => $accessToken->plainTextToken,
                'access_token_expires_at' => $accessToken->accessToken->expires_at,
                'refresh_token' => $refreshToken->plainTextToken,
                'refresh_token_expires_at' => $refreshToken->accessToken->expires_at,
            ],
        ];

        return response()->json($response, 200);
    }
}

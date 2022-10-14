<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
class AuthController extends Controller
{
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
            'password' => Hash::make($request->password)
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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
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

    public function cleanToken(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()->json([
            'message' => 'Successfully logged out all devices!'
        ]);
    }

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
            ]
        ];

        return response()->json($response, 200);
    }
}

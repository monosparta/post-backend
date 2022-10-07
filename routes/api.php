<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\V1\AuthController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('token-clear', [AuthController::class, 'cleanToken']);
    Route::get('refresh-token', [AuthController::class, 'refreshToken'])->name('api.token.refresh');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users/categories', UserCategoryController::class);
    Route::apiResource('users', UserController::class);
    Route::post('users/{user}/profile', [UserController::class, 'profile']);
    Route::post('users/{user}/organization', [UserController::class, 'organization']);
    Route::post('users/{user}/emergency-contact', [UserController::class, 'emergencyContact']);
});
Route::apiResource('post', PostController::class);

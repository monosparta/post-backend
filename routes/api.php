<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCategoryController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

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

Route::prefix('v1')->middleware(['assign.guard:admin'])->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('register', [AdminAuthController::class, 'register']);
});

Route::prefix('v1')->middleware(['assign.guard:admin', 'auth:sanctum'])->group(function () {
    Route::post('token-clear', [AdminAuthController::class, 'cleanToken']);
    Route::get('refresh-token', [AdminAuthController::class, 'refreshToken'])->name('api.token.refresh');
});

/* Member System */
Route::middleware(['assign.guard:admin', 'auth:sanctum'])->group(function () {
    Route::post('users/index', [UserController::class, 'datatable']);
    Route::post('userCategories/index', [UserCategoryController::class, 'datatable']);
    Route::apiResource('userCategories', UserCategoryController::class);
    Route::apiResource('users', UserController::class);
    Route::post('users/{user}/profile', [UserController::class, 'profile']);
    Route::post('users/{user}/organization', [UserController::class, 'organization']);
    Route::post('users/{user}/emergency-contact', [UserController::class, 'emergencyContact']);
    Route::post('users/{user}/note', [UserController::class, 'note']);
});

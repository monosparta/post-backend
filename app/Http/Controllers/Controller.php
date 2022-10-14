<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="MMSv2",
 *      description="Monospace Member System API 文件",
 * ),
 * @OA\Tag(
 *      name="V1/Auth",
 *      description="Use Token Authentication"
 * ),
 * @OA\Tag(
 *      name="Enumerate Dropdown",
 *      description="Enumerate of drop down list"
 * ),
 * @OA\Tag(
 *      name="Enumerate",
 *      description="Admin CRUD Enumerate"
 * ),
 * @OA\Tag(
 *      name="EnumerateItem",
 *      description="Admin CRUD Enumerate Item"
 * ),
 * @OA\Tag(
 *      name="Users",
 *      description="Admin CRUD User"
 * ),
 * @OA\Tag(
 *      name="UserCategory",
 *      description="Admin CRUD UserCategory"
 * ),
 * @OA\Tag(
 *      name="Bulletin Board",
 *      description="API Endpoints of Bulletin Comment"
 * ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

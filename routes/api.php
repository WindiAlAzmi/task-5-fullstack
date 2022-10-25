<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ArticlesController;
use App\Http\Controllers\API\UserController;
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

Route::post('/v1/users/register', [UserController::class, 'register']);
Route::post('/v1/users/login', [UserController::class, 'login']);
Route::get('/v1/users/details', [UserController::class, 'details'])->middleware('auth:api');
Route::post('/v1/users/logout', [UserController::class, 'logout'])->middleware('auth:api');


// Route::apiResource('/v1/categories', CategoryController::class, array("as" => "api"))->middleware('auth:api');
// Route::apiResource('/v1/articles', ArticlesController::class)->middleware('auth:api');

Route::apiResources([
    '/v1/categories' => CategoryController::class,
    '/v1/articles' => ArticlesController::class
], [
    'middleware' => 'auth:api',
     'as' => 'api'
]);
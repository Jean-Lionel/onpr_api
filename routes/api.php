<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get("articles", [ArticleController::class, "index"]);
Route::apiResource('youtube_medias', ArticleController::class,
    [
        'except' => ['index', 'show']
    ]);
Route::get("/searchArticle/{key_word}", [ArticleController::class, 'search']);


Route::middleware('auth:sanctum')->group(function () {
 
    Route::get('/me',[AuthController::class, 'me']);
    // Route::post('/articles', [ArticleController::class, 'store']);
    
    Route::apiResource('articles', ArticleController::class,
        [
            'except' => ['index', 'show']
        ]);
    Route::apiResource('youtube_medias', ArticleController::class,
        [
            'except' => ['index', 'show']
        ]);

    Route::apiResource('users', UserController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

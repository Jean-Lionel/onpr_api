<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AdminHeaderController;
use App\Http\Controllers\DeclarationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\DownloawdDocController;
use App\Http\Controllers\YoutubeMediaController;
use App\Http\Controllers\FileDeclarationController;
use App\Http\Controllers\CotisationAfilierController;
use App\Http\Controllers\CotisationDetacheController;
use App\Http\Controllers\OnlineDeclarationDetacheController;

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

Route::apiResource('youtube_medias', YoutubeMediaController::class,[
            'except' => ['store', 'destroy']
        ]);

 Route::apiResource('articles', ArticleController::class,[
            'accept' => ['index', 'show']
        ]);

Route::apiResource('youtube_medias', ArticleController::class,[
        'except' => ['index', 'show']
    ]);
Route::apiResource('slides', SlideController::class, [
        'accept' => ['index', 'show']
    ]);
Route::apiResource('file_declarations', FileDeclarationController::class);
Route::get("/searchArticle/{key_word ?}", [ArticleController::class, 'search']);
Route::get("/toutArticles", [ArticleController::class, 'toutArticles']);

Route::get("cotisations_afiliers/{matricule}", [CotisationAfilierController::class, "searchByMatricule"]);

Route::get("cotisation_detaches/{matricule}", [CotisationDetacheController::class, "searchByMatricule"]);

Route::post("declaration", [DeclarationController::class, 'store']);

 Route::apiResource('adminheades', AdminHeaderController::class,[
            'accept' => ['index', 'show']
        ]);
  Route::apiResource('admin_contents', AdminContentController::class,[
            'accept' => ['index', 'show']
        ]);
  Route::apiResource('downloawddoc', DownloawdDocController::class,[
            'accept' => ['index', 'show']
        ]);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/me',[AuthController::class, 'me']);
    // Route::post('/articles', [ArticleController::class, 'store']);
    Route::apiResource('articles', ArticleController::class,[
            'except' => ['index', 'show']
        ]);
    Route::apiResource('slides', SlideController::class,[
            'except' => ['index', 'show']
        ]);
    Route::apiResource('downloawddoc', DownloawdDocController::class,[
            'except' => ['index', 'show']
        ]);

    // Route::get("users/institution/{id}", [UserController::class, 'get_user_by_instutions' ])

    Route::get('get_user_by_instutions/{institution_id}', [InstitutionController::class, 'get_user_by_instutions'
    ]);
    Route::get('get_user_instution', [InstitutionController::class, 'getUserInstution'
    ]);
    Route::apiResource('youtube_medias', YoutubeMediaController::class,[
            'except' => ['index', 'show']
        ]);
    Route::apiResource('adminheades', AdminHeaderController::class,[
            'except' => ['index', 'show']
        ]);
    Route::apiResource('admin_contents', AdminContentController::class,[
            'except' => ['index', 'show']
        ]);
    Route::apiResource('declarations', DeclarationController::class);
    Route::post('/cotisations', [CotisationAfilierController::class, 'saveUploadData']);
    Route::post('/cotisations_detaches', [CotisationDetacheController::class, 'saveUploadData']);

    Route::get("unReadDeclaration", [DeclarationController::class, 'unReadDeclaration']);

    Route::apiResource('users', UserController::class);

    Route::apiResource('cotisation_detaches', CotisationDetacheController::class);
    Route::apiResource('online_declaration_detaches', OnlineDeclarationDetacheController::class);
    Route::apiResource('cotisation_afiliers', CotisationAfilierController::class);
    Route::apiResource('institutions', InstitutionController::class);
    Route::get('institutions/groupby/{typeInstution}', [InstitutionController::class, 'groupby']);
    Route::get('institutions/search/{search_key}', [InstitutionController::class, 'search']);
    Route::apiResource('roles', RoleController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

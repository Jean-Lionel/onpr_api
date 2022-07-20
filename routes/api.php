<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\AnnonceController;
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

Route::post('/register', [AuthController::class, 'register'])->middleware('cors');
Route::post('/login', [AuthController::class, 'login'])->middleware('cors');

Route::apiResource('youtube_medias', YoutubeMediaController::class,[
            'except' => ['store', 'destroy']
        ])->middleware('cors');

 Route::apiResource('articles', ArticleController::class,[
            'accept' => ['index', 'show']
        ])->middleware('cors');

Route::apiResource('youtube_medias', ArticleController::class,[
        'except' => ['index', 'show']
    ])->middleware('cors');
Route::apiResource('slides', SlideController::class, [
        'accept' => ['index', 'show']
    ])->middleware('cors');
Route::apiResource('file_declarations', FileDeclarationController::class)->middleware('cors');
Route::get("/searchArticle/{key_word ?}", [ArticleController::class, 'search'])->middleware('cors');
Route::get("/toutArticles", [ArticleController::class, 'toutArticles'])->middleware('cors');

Route::get("cotisations_afiliers/{matricule}", [CotisationAfilierController::class, "searchByMatricule"])->middleware('cors');

Route::get("cotisation_detaches/{matricule}", [CotisationDetacheController::class, "searchByMatricule"])->middleware('cors');

Route::post("declaration", [DeclarationController::class, 'store'])->middleware('cors');

 Route::apiResource('adminheades', AdminHeaderController::class,[
            'accept' => ['index', 'show']
        ])->middleware('cors');
    Route::apiResource('admin_contents', AdminContentController::class,[
            'accept' => ['index', 'show']
        ])->middleware('cors');
     Route::apiResource('downloawddoc', DownloawdDocController::class,[
            'accept' => ['index', 'show']
        ])->middleware('cors');
     Route::apiResource('annonces', AnnonceController::class,[
            'accept' => ['index', 'show']
        ])->middleware('cors');
    Route::middleware(['auth:sanctum','cors'])->group(function () {
    
    Route::get('/me',[AuthController::class, 'me']);

    Route::get('list_chargements', [ CotisationAfilierController::class, 'list_chargements']);
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
    Route::apiResource('annonces', AnnonceController::class,[
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
    Route::get('declarations/search/{search_key}', [DeclarationController::class, 'search']); 

    Route::post('/cotisations', [CotisationAfilierController::class, 'saveUploadData']);
    Route::post('/cotisations_detaches', [CotisationDetacheController::class, 'saveUploadData']);

    Route::get("unReadDeclaration", [DeclarationController::class, 'unReadDeclaration']);

    Route::apiResource('users', UserController::class);

    Route::apiResource('cotisation_detaches', CotisationDetacheController::class);
    Route::apiResource('online_declaration_detaches', OnlineDeclarationDetacheController::class);
    Route::apiResource('cotisation_afiliers', CotisationAfilierController::class);
    Route::apiResource('institutions', InstitutionController::class);
    Route::post('cotisation_annuler/{traitement}/{table}', [CotisationAfilierController::class, 'annuler']);
    Route::get('institutions/groupby/{typeInstution}', [InstitutionController::class, 'groupby']);
    Route::get('institutions/search/{search_key}', [InstitutionController::class, 'search']);  
    Route::get('users/search/{search_key}', [UserController::class, 'search']);
    Route::apiResource('roles', RoleController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

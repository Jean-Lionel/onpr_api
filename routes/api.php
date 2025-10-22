<?php
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');


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
use App\Http\Controllers\InformationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\DownloawdDocController;
use App\Http\Controllers\YoutubeMediaController;
use App\Http\Controllers\FileDeclarationController;
use App\Http\Controllers\CotisationAfilierController;
use App\Http\Controllers\CotisationDetacheController;
use App\Http\Controllers\OnlineDeclarationDetacheController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BriefController;
use App\Http\Controllers\PhotoWeekController;

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


Route::post('register', [AuthController::class, 'register']);
Route::post('saveMember', [UserController::class,  'saveMember']);
Route::post('login', [AuthController::class, 'login']);
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
Route::get("searchArticle/{key_word ?}", [ArticleController::class, 'search']);
Route::get("Translator_art", [ArticleController::class, 'articleTranslater']);
Route::get("toutArticles", [ArticleController::class, 'toutArticles']);

Route::get("cotisations_afiliers/{matricule}", [CotisationAfilierController::class, "searchByMatricule"]);



//Route::apiResource("declaration", [DeclarationController::class, 'store']);

 Route::apiResource('adminheades', AdminHeaderController::class,[
            'accept' => ['index', 'show']
        ]);
    Route::apiResource('admin_contents', AdminContentController::class,[
            'accept' => ['index', 'show']
        ]);
     Route::apiResource('downloawddoc', DownloawdDocController::class);
     Route::apiResource('annonces', AnnonceController::class,[
            'accept' => ['index', 'show']
        ]);
     Route::get("Translator_annon", [AnnonceController::class, 'annonceTranslater']);

     Route::apiResource('declarations', DeclarationController::class);
    // =========================================================
    Route::middleware(['auth:sanctum', 'can:is-Notmember'])->group(function () {

    Route::get('me',[AuthController::class, 'me']);

    Route::get('list_chargements', [ CotisationAfilierController::class, 'list_chargements']);
    // Route::post('/articles', [ArticleController::class, 'store']);
    Route::apiResource('articles', ArticleController::class,[
            'except' => ['index', 'show']
        ]);
    Route::apiResource('slides', SlideController::class,[
            'except' => ['index', 'show']
        ]);
    // Route::apiResource('downloawddoc', DownloawdDocController::class,[
    //         'except' => ['index', 'show']
    //     ]);
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
    Route::post('adminheadesTraduction', [AdminHeaderController::class, "adminheadesTraduction"]);
    Route::apiResource('admin_contents', AdminContentController::class,[
            'except' => ['index', 'show']
        ]);
    Route::post("admin_contents_translate", [AdminContentController::class, "admin_contents_translate"]);

    Route::get('declarations/search/{search_key}', [DeclarationController::class, 'search']);
    Route::post('cotisations', [CotisationAfilierController::class, 'saveUploadData']);
    Route::post('cotisations_detaches', [CotisationDetacheController::class, 'saveUploadData']);
    Route::get("unReadDeclaration", [DeclarationController::class, 'unReadDeclaration']);
    Route::apiResource('users', UserController::class);

    Route::apiResource('online_declaration_detaches', OnlineDeclarationDetacheController::class);
    Route::apiResource('cotisation_afiliers', CotisationAfilierController::class);
    Route::apiResource('institutions', InstitutionController::class);
    Route::post('cotisation_annuler/{traitement}/{table}', [CotisationAfilierController::class, 'annuler']);
    Route::get('institutions/groupby/{typeInstution}', [InstitutionController::class, 'groupby']);
    Route::get('institutions/search/{search_key}', [InstitutionController::class, 'search']);
    Route::get('users/search/{search_key}', [UserController::class, 'search']);
    Route::apiResource('roles', RoleController::class);
   Route::apiResource('cotisation_detaches', CotisationDetacheController::class);

   Route::get('get_member/{matricule?}', [UserController::class , 'getMember']);
   Route::post('change_user_password', [UserController::class , 'change_user_password']);

});

Route::apiResource('gallery', GalleryController::class);
Route::get('gallery/categories', [GalleryController::class, 'getCategories']);


Route::apiResource('events', EventController::class);
Route::get('event/upcoming', [EventController::class, 'upcoming']);
Route::get('event/categories', [EventController::class, 'getCategories']);

Route::apiResource('briefs', BriefController::class);
Route::get('brief/recent', [BriefController::class, 'recent']);
Route::get('brief/today', [BriefController::class, 'today']);

Route::apiResource('photo-week', PhotoWeekController::class);
Route::get('photo-weeks/active', [PhotoWeekController::class, 'active']);

// Route pour un visiteur connecté
Route::middleware(['auth:sanctum', 'can:is-member'])->group(function(){

    Route::get("cotisation_detaches", [CotisationDetacheController::class, "searchByMatricule"]);
    Route::post('change_password', [UserController::class, 'change_password']);

});

Route::post('logout', [AuthController::class, 'logout']);

 Route::apiResource('informations', InformationController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/clear', function (Request $request) {

    $clearconfig = Artisan::call('config:cache');
    echo "Config cleared<br>";

    $clearcache = Artisan::call('cache:clear');
    echo "Cache cleared<br>";
    $clearview = Artisan::call('view:clear');
    echo "View cleared<br>";

    echo "MIGRATE SUCCES";
});


Route::apiResource('contacts', App\Http\Controllers\ContactController::class);

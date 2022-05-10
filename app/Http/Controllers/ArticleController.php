<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/articles",
     *      operationId="articlesList",
     *      tags={"articles"},
     *      summary="Get list of projects",
     *      description="Returns list of projects",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *            )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    public function index()
    {

        return Article::latest()->paginate();
    }

    /**
     * @OA\Post(
     *     path="/api/articles",
     *    operationId="storeArticle",
     *   tags={"articles"},
     *  summary="Store a new article",
     * description="Store a new article",
     * @OA\RequestBody(
     *    required=true,
     *   description="Article object that needs to be added to the database",
     * ),
     * @OA\Response(
     *    response=201,
     *   description="Article created successfully",
     *  @OA\MediaType(
     *    mediaType="application/json",
     *  )
     * )
     * )
     *
     */

    public function store(StoreArticleRequest $request)
    {
        $article = Article::create($request->all());

        return response()->json([
            "success" => "Arcticle created",
            "article" => $article

        ], 201);
    }


    public function show(Article $article)
    {
        //
    }


    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }


    public function destroy(Article $article)
    {
        //
    }
}

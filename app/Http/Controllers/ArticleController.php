<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UploadFile;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Image;

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
        if(!$request->hasFile("image")) {
            return response()->json(['upload_file_not_found'], 400);
        }

        $imageName = '';
        if (isset($request->image)) {
            # code...
            $file = $request->file("image"); 
            $allowedfileExtension=['jpeg','jpg','png','jpeg'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);

            if (!$check) {
            // code...
                return response()->json(['error' => 'Unknown extention type '], 400); 
             }
           
            $image = $request->file('image');

            $imageName = time() . '.'. $image->getClientOriginalExtension();

            $destinationPath  = public_path('img\articles');
            $imageFile = Image::make($image->getRealPath());

            $imageFile->resize(400,600,function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath .'/'.   $imageName);

            // $destinationPath = public_path('/uploads');
            // $image->move($destinationPath, $imageName);
        }

        $article = Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imageName ,           
            'image_alt' => $request->title,

        ]);

        return response()->json([
            "success" => "Arcticle created",
            "article" => $article

        ], 201);
    }


    public function show(Article $article)
    {
        return $article;
    }

    public function search($key_word){
        $listeArclices = Article::where(function($query) use($key_word){
            $query->where('title','LIKE', '%'.$key_word.'%')
                  ->OrWhere('body', 'LIKE', '%'.$key_word.'%')
                  ->OrWhere('slug', 'LIKE', '%'.$key_word.'%')
                  ;
        })->paginate();
        return $listeArclices;
    }


    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update($request->all());

        return response()->json([
            "success" => "update successfully",
            "article" => $article
        ],200);
    }


    public function destroy(Article $article)
    {
       $article->delete();
       return response()->json([
        "success" => "delete successfully",
       ],200);
    }
}

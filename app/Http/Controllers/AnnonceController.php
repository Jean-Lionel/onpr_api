<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Http\Requests\StoreAnnonceRequest;
use App\Http\Requests\UpdateAnnonceRequest;
use Stichoza\GoogleTranslate\GoogleTranslate;
use GuzzleHttp\Exception\ConnectException;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Annonce::latest()->paginate();
    }

    public function annonceTranslater(Request $request){
        
        if (!empty($request->body)) {
            $Error = 'Erreur de connexion';
            $tr = new GoogleTranslate();
            try {
                return $tr->setSource('fr')->setTarget('en')->translate($request->body);
            } catch(ConnectException $e){
                return $ErrorConnection;
            }
        }else{
            return 'Please, add some text to translate';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnnonceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnnonceRequest $request)
    {   
        $tr = new GoogleTranslate(); // Translates into English
        Annonce::create([
            'body' =>  $request->body,
            'body_en'=> $request->body_en ?? articleTranslater($request->body),
            'title' =>  $request->title,
            'title_en' =>$request->title_en ?? articleTranslater($request->title),
            'user_id' =>  auth('sanctum')->user()->id,
        ]);

        return response()->json([
            'success' => 'created success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function show(Annonce $annonce)
    {
        //
        return $annonce;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnnonceRequest  $request
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnnonceRequest $request,  $id)
    {
        // Translates into English

        $annonce = Annonce::find($id);
         $annonce->update([
            'body_en'=> $request->body,
            'title_en' =>$request->title,
            'user_id' =>  auth('sanctum')->user()->id,
        ]);

        return response()->json([
            'success' => 'updated success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy( $annonce)
    {
        Annonce::find($annonce)->delete();
        return response()->json([
            'success' => 'deleted'
        ]);
    }
}

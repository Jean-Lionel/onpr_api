<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Http\Requests\StoreAnnonceRequest;
use App\Http\Requests\UpdateAnnonceRequest;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnnonceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnnonceRequest $request)
    {
        Annonce::create([
            'body' =>  $request->body,
            'title' =>  $request->title,
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
    public function update(UpdateAnnonceRequest $request, Annonce $annonce)
    {
        //
         $annonce->update([
            'body' =>  $request->body,
            'title' =>  $request->title,
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
        //

        Annonce::find($annonce)->delete();
        return response()->json([
            'success' => 'deleted'
        ]);

    }
}

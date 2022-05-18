<?php

namespace App\Http\Controllers;

use App\Models\CotisationAfilier;
use App\Http\Requests\StoreCotisationAfilierRequest;
use App\Http\Requests\UpdateCotisationAfilierRequest;
use Illuminate\Http\Request;

class CotisationAfilierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return CotisationAfilier::latest()->paginate(10);
    }

    /**
     * store data
     * @param    $request
     **/

    public function saveUploadData(Request $request){
        $body = json_decode($request->data, true);

       $user_id =  auth('sanctum')->user()->id ?? 0;
        $body = collect($body)->map(function($ligne) use ($user_id){
            $ligne['user_id'] = $user_id;

            return $ligne;
        });
        CotisationAfilier::insert($body->toArray());

        return $body;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCotisationAfilierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCotisationAfilierRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CotisationAfilier  $cotisationAfilier
     * @return \Illuminate\Http\Response
     */
    public function show(CotisationAfilier $cotisationAfilier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCotisationAfilierRequest  $request
     * @param  \App\Models\CotisationAfilier  $cotisationAfilier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCotisationAfilierRequest $request, CotisationAfilier $cotisationAfilier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CotisationAfilier  $cotisationAfilier
     * @return \Illuminate\Http\Response
     */
    public function destroy(CotisationAfilier $cotisationAfilier)
    {
        //
    }
}
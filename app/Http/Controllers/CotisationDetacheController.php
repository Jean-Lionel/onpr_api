<?php

namespace App\Http\Controllers;

use App\Models\CotisationDetache;
use App\Http\Requests\StoreCotisationDetacheRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCotisationDetacheRequest;

class CotisationDetacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CotisationDetache::latest()->paginate(10);
    }

    public function saveUploadData(Request $request){
        $request->validate([
            'institution_id' => 'required',
        ]);
       $user_id =  auth('sanctum')->user()->id ?? 0;
       $institution_id = $request->institution_id;

        $body = json_decode($request->data, true);
        $user_id =  auth('sanctum')->user()->id ?? 0;
        $body = collect($body)->map(function($ligne) use ($user_id, $institution_id){
                $ligne['user_id'] = $user_id;
                $ligne['institution_id'] = $institution_id;
                return $ligne;
            });

        CotisationDetache::insert($body->toArray());

        return response()->json([
            "success" => "cotisation des detaches upploded successfully"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCotisationDetacheRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCotisationDetacheRequest $request)
    {
        //
        $body = json_decode($request->data, true);
        $user_id =  auth('sanctum')->user()->id ?? 0;
            $body = collect($body)->map(function($ligne) use ($user_id){
                $ligne['user_id'] = $user_id;

                return $ligne;
            });

        return response()->json([
            "success" => "cotisation upploded successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CotisationDetache  $cotisationDetache
     * @return \Illuminate\Http\Response
     */
    public function show(CotisationDetache $cotisationDetache)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCotisationDetacheRequest  $request
     * @param  \App\Models\CotisationDetache  $cotisationDetache
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCotisationDetacheRequest $request, CotisationDetache $cotisationDetache)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CotisationDetache  $cotisationDetache
     * @return \Illuminate\Http\Response
     */
    public function destroy(CotisationDetache $cotisationDetache)
    {
        //
    }
}

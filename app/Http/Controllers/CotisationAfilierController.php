<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CotisationAfilier;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCotisationAfilierRequest;
use App\Http\Requests\UpdateCotisationAfilierRequest;

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
        return CotisationAfilier::with("institution")->latest()->paginate(10);
    }

    public function searchByMatricule($matricule)
    {

        $cotisations = CotisationAfilier::where('matricule', '=',$matricule )
        ->orderBy('annee','DESC')->orderBy('mois', 'DESC')->get();

        return $cotisations->count() ? $cotisations : "Le Numéro Matricule introuvable";
    }

    /**
     * store data
     * @param    $request
     **/

    public function saveUploadData(Request $request){
        $body = json_decode($request->data, true);

        $data = array_chunk($body, 1000);

        try {
            DB::beginTransaction();
            foreach($data as $v){
                CotisationAfilier::insert($v);
            }
            DB::commit();
            
        } catch (Exception $e) {
            
            DB::rollback();

            return $e;
        }

        

        return 'success';
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

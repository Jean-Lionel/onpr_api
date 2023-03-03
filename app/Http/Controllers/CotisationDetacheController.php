<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CotisationAfilier;
use App\Models\CotisationDetache;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCotisationDetacheRequest;
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
        return CotisationDetache::with("institution")->latest()->paginate(10);
    }

    public function searchByMatricule()
    {

        $matricule  = auth()->user()->numero_matricule;

        //dd($matricule );

         $detaches= CotisationDetache::where('matricule', '=',$matricule )
        ->orderBy('annee','DESC')->orderBy('mois', 'DESC')->get();

        $affilies = CotisationAfilier::where('matricule', '=',$matricule )
        ->orderBy('annee','DESC')->orderBy('mois', 'DESC')->get();

        $cotisations = $detaches->merge($affilies);

        return $cotisations->count() ? $cotisations : "Le Numéro Matricule introuvable";
    }


    public function saveUploadData(Request $request){
       
          $body = json_decode($request->data, true);

          $trie_data = trimData($body);

        $data = array_chunk($trie_data, 7000);
        try {
            DB::beginTransaction();
            foreach($data as $v){
                 CotisationDetache::insert($v);
            }
            DB::commit();
            
        } catch (Exception $e) {
            
            DB::rollback();

            return response()->json($e->getMessage(), 500) ;
        }

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

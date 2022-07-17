<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstitutionRequest;
use App\Http\Requests\UpdateInstitutionRequest;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Institution::latest()->paginate(10);
    }

    public function get_user_by_instutions($institution_id)
    {
        $users = User::where('institution_id', '=',$institution_id)->get();

        return $users;
    }

    public function groupby($typeInstution)
    {
       $instustitions = Institution::where('typeInstution','like', $typeInstution)->get();

       return $instustitions;
    }

    public function getUserInstution(){

        $user = auth('sanctum')->user();

        $instustition = Institution::where('id', $user->institution_id)->get();

        if($instustition->count() == 0){
            return response()->json([
                'error' => "Vous n'avais aucun droit de déclaration"
            ], 403);
        }
        return $instustition;
    }

    public function search($search_key){

         //$search_key = $request->query('search_key');

         if($search_key == 'ALL_DATA') return $this->index();
        $institutions = Institution::where(function($query) use ($search_key){
            if($search_key){
                $query->where('name', 'like', '%'.$search_key . '%' )
                  ->orWhere('telephone', 'like', '%'.$search_key. '%')
                  ->orWhere('email', 'like', '%'.$search_key. '%')
                  ->orWhere('address', 'like', '%'.$search_key. '%');

            }
            

        })->paginate(10);


        return $institutions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstitutionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstitutionRequest $request)
    {
        Institution::create($request->all());

        return response()->json(
           [ 
            'success' =>  "Institution created successfully"
        ]
           ,200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function show(Institution $institution)
    {
        return $institution;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstitutionRequest  $request
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstitutionRequest $request, Institution $institution)
    {
        //
        $institution->update($request->all());
        
        return response()->json([
            "success" => "Created successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function destroy($institution)
    {
        //
        Institution::find($institution)->delete();

        return response()->json([
            "success" => "Deleted successfully"
        ]);
    }
}

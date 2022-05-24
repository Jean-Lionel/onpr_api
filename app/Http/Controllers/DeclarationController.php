<?php

namespace App\Http\Controllers;

use App\Models\Declaration;
use App\Http\Requests\StoreDeclarationRequest;
use App\Http\Requests\UpdateDeclarationRequest;

class DeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Declaration::latest()->paginate();
    }

    public function unReadDeclaration(){

       $nombre =  Declaration::where('is_opened', 0)->get()->count();
       return response()->json([
        "success" => $nombre
       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeclarationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeclarationRequest $request)
    {
        $file_name_1 = "";
        $file_name_2 = "";
        $file_name_3 = "";
        if ($request->file_justification_1){
           $file_name_1 = time().'.'.$request->file_justification_1->extension();  
           $request->file_justification_1->move(public_path('documents/uploads'), $file_name_1);
       }
       if ($request->file_justification_2){
        $file_name_2 = time().'.'.$request->file_justification_2->extension();  
        $request->file_justification_2->move(public_path('documents/uploads'), $file_name_2);
        }
    if ($request->file_justification_3){
        $file_name_3 = time().'.'.$request->file_justification_3->extension();  
        $request->file_justification_3->move(public_path('documents/uploads'), $file_name_3);
         }
        $request->file_justification_1 = $file_name_1;
        $request->file_justification_2 = $file_name_2;
        $request->file_justification_3 = $file_name_3;


    Declaration::create([
        'file_name_3' => $request->file_name_3,
        'file_name_2' => $request->file_name_2,
        'file_name_1' => $request->file_name_1,
        'victime_telephone' => $request->victime_telephone,
        'victime_matricule' => $request->victime_matricule,
        'type_declaration' => $request->type_declaration,
        'victime_prenom' => $request->victime_prenom,
        'nom_instution' => $request->nom_instution,
        'adresse' => $request->adresse,
        'telephone' => $request->telephone,
        'email' => $request->email,
        'nom_declarant' => $request->nom_declarant,
        'motif_declaration' => $request->motif_declaration,
        'date_declaration' => $request->date_declaration,
        'victime_name' => $request->victime_name,
        'file_justification_1' => $file_name_1,
        'file_justification_2' => $file_name_2,
        'file_justification_3' => $file_name_3,
    ]);

    return response()->json([
        "success" => "Déclaration created successfully"
    ]);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function show(Declaration $declaration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeclarationRequest  $request
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeclarationRequest $request, Declaration $declaration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Declaration $declaration)
    {
        //
    }
}

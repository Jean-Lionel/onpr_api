<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeclarationRequest;
use App\Http\Requests\UpdateDeclarationRequest;
use App\Models\Declaration;
use App\Models\OnlineDeclarationDetache;
use App\Models\UserReadMessage;

class DeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Declaration::latest()->paginate(10);
    }

    public function unReadDeclaration(){

       $web_declaration =  Declaration::where('is_opened', 0)->get()->count();
       $instution_declaration = OnlineDeclarationDetache::where('is_opened', 0)->get()->count();
       
       return response()->json([
        "web_declaration" => $web_declaration,
        "instution_declaration" => $instution_declaration,
       ]);
    }

    public function search($search_key){

         //$search_key = $request->query('search_key');

         if($search_key == 'ALL_DATA') return Declaration::latest()->paginate(10);

        $institutions = Declaration::where(function($query) use ($search_key){
            if($search_key){
                $query->where('nom_instution', 'like', '%'.$search_key . '%' )
                  ->orWhere('telephone', 'like', '%'.$search_key. '%')
                  ->orWhere('email', 'like', '%'.$search_key. '%')
                  ->orWhere('nom_declarant', 'like', '%'.$search_key. '%')
                  ->orWhere('motif_declaration', 'like', '%'.$search_key. '%')
                  ->orWhere('date_declaration', 'like', '%'.$search_key. '%')
                  ->orWhere('victime_name', 'like', '%'.$search_key. '%')
                  ->orWhere('victime_prenom', 'like', '%'.$search_key. '%')
                  ->orWhere('victime_matricule', 'like', '%'.$search_key. '%')
                  ->orWhere('victime_telephone', 'like', '%'.$search_key. '%')
                  ->orWhere('victime_fonction', 'like', '%'.$search_key. '%');

            }
            
        })->paginate(10);


        return $institutions;
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


        try {
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
            
        } catch (\Exception $e) {
            return response()->json([
                "success" => false, 
                "msg" => $e->getMessage(),
         ]);
            
        }


    return response()->json([
        "success" => true, 
        "msg" => "Déclaration created successfully"
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
        $declaration->update([
            'is_opened' => 1
        ]);

        UserReadMessage::create([
            'declaration_id' => $declaration->id
        ]);

        $declaration->file_justification_1 = $declaration->getFile_1Attribute();
        $declaration->file_justification_2 = $declaration->getFile_2Attribute();
        $declaration->file_justification_3 = $declaration->getFile_3Attribute();

        return $declaration;
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOnlineDeclarationDetacheRequest;
use App\Http\Requests\UpdateOnlineDeclarationDetacheRequest;
use App\Models\DeclarationReadUser;
use App\Models\OnlineDeclarationDetache;
use App\Models\User;

class OnlineDeclarationDetacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $user = auth("sanctum")->user();


        if(!$user->isAdmin() && !$user->isChefRecouvrement() ){
            return OnlineDeclarationDetache::where('user_id', $user->id)->with('user')->latest()->paginate(10);

        }

        return OnlineDeclarationDetache::with('user')->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOnlineDeclarationDetacheRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOnlineDeclarationDetacheRequest $request)
    {
         $file_name_1 = '';
         $file_name_2 = '';

        if (isset($request->file_uploaded_1)) {
            // code...
          $extension  = $request->file_uploaded_1->extension();
          if($extension !== 'pdf'){
            return response()->json([
                ['error' => 'Le fichier de type  '.$extension. " n'est pas accepté . " ]
            ], 400);
          }

          $file_name_1 = time().'.'.$extension;

           $request->file_uploaded_1->move(public_path('documents/declaration'), $file_name_1);
        }
        if (isset($request->file_uploaded_2)) {
            // code...
          $extension  = $request->file_uploaded_2->extension();
          if($extension !== 'pdf'){
            return response()->json([
                ['error' => 'Le fichier de type  '.$extension. " n'est pas accepté . " ]
            ], 400);
          }
          $file_name_2 = time().'.'.$extension;
           $request->file_uploaded_2->move(public_path('documents/declaration'), $file_name_2);
        }


        OnlineDeclarationDetache::create([
                "titre" => $request->titre,
                "code_instution" => $request->code_instution,
                "nom_instution" => $request->nom_instution,
                "mois" => $request->mois,
                "annee" => $request->annee,
                "date_declaration" => $request->date_declaration,
                "description" => $request->description,
                "file_name_one" => $request->file_name_1,
                "file_uploaded_one" => $file_name_1,
                "file_name_two" => $request->file_name_2,
                "file_uploaded_two" => $file_name_2,
                "user_id" => auth('sanctum')->user()->id,
                "institution_id" => $request->institution_id,

        ]);

        return response()->json([
            "success" => 'Vos données ont été envoyé'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OnlineDeclarationDetache  $onlineDeclarationDetache
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $declaration =  OnlineDeclarationDetache::find($id);

      // return $declaration;
        $user = User::find($declaration->user_id);

        if($user){
           $user = $user->first(); 
        }

        

        if(auth('sanctum')->user()->isAdmin() || auth('sanctum')->user()->isChefRecouvrement()){
            $declaration->is_opened = true;
            $declaration->save();

            DeclarationReadUser::create([
                'user_id' => auth('sanctum')->user()->id,
                'online_declaration_detache_id' => $declaration->id,
            ]);
        }
        return [
            'declaration' =>$declaration,
            'user' => $user ? $user->name : "INCONNUE",
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOnlineDeclarationDetacheRequest  $request
     * @param  \App\Models\OnlineDeclarationDetache  $onlineDeclarationDetache
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOnlineDeclarationDetacheRequest $request, OnlineDeclarationDetache $onlineDeclarationDetache)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OnlineDeclarationDetache  $onlineDeclarationDetache
     * @return \Illuminate\Http\Response
     */
    public function destroy( $onlineDeclarationDetache)
    {
        //
        OnlineDeclarationDetache::find($onlineDeclarationDetache)->delete();
        return response()->json([
            "success" => "deleted successfully"
        ]);
    }
}

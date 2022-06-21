<?php

namespace App\Http\Controllers;

use App\Models\FileDeclaration;
use App\Http\Requests\StoreFileDeclarationRequest;
use App\Http\Requests\UpdateFileDeclarationRequest;

class FileDeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFileDeclarationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileDeclarationRequest $request)
    {
        //
        if(!$request->hasFile("file")) {
            return response()->json(['upload_file_not_found'], 400);
        }

        $imageName = '';

        if (isset($request->file)) {
            # code...
            $file = $request->file("file"); 
            $allowedfileExtension=['pdf','xls','xlsx'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
            if (!$check) {
            // code...
                return response()->json(
                    ['error' => 'Unknown extention type '], 400); 
             }
             $imageName = time() . '.'. $file->getClientOriginalExtension();

             $destinationPath = public_path('/uploads/form');
            $file->move($destinationPath, $imageName);
         }

         FileDeclaration::create([
            'title' => $request->title,
            'downloawd_doc_id' => $request->downloawd_doc_id,
            'name' => $imageName
         ]);

        return response()->json([
            'success' => 'Enregistrment reussi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileDeclaration  $fileDeclaration
     * @return \Illuminate\Http\Response
     */
    public function show(FileDeclaration $fileDeclaration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileDeclarationRequest  $request
     * @param  \App\Models\FileDeclaration  $fileDeclaration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileDeclarationRequest $request, FileDeclaration $fileDeclaration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileDeclaration  $fileDeclaration
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileDeclaration $fileDeclaration)
    {
        //
    }
}

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

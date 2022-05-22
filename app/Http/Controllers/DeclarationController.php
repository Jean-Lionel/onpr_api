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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeclarationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeclarationRequest $request)
    {
        //
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

<?php

namespace App\Http\Controllers;

use App\Models\Detache;
use App\Http\Requests\StoreDetacheRequest;
use App\Http\Requests\UpdateDetacheRequest;

class DetacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDetacheRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetacheRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Detache  $detache
     * @return \Illuminate\Http\Response
     */
    public function show(Detache $detache)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetacheRequest  $request
     * @param  \App\Models\Detache  $detache
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetacheRequest $request, Detache $detache)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detache  $detache
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detache $detache)
    {
        //
    }
}

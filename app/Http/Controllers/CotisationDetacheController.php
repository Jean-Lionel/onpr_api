<?php

namespace App\Http\Controllers;

use App\Models\CotisationDetache;
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
        //
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

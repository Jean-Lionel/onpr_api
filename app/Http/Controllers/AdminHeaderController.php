<?php

namespace App\Http\Controllers;

use App\Models\AdminHeader;
use App\Http\Requests\StoreAdminHeaderRequest;
use App\Http\Requests\UpdateAdminHeaderRequest;

class AdminHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return AdminHeader::with("admin_contents")->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdminHeaderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminHeaderRequest $request)
    {
        $a = AdminHeader::create([
            'title' => $request->title,
            'user_id' => auth('sanctum')->user()->id ?? 0
        ]);

        return response()->json([
            'success' => 'Enregistrment réussi',
            'header' => $a
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminHeader  $adminHeader
     * @return \Illuminate\Http\Response
     */
    public function show($adminHeader)
    {
        //admin_contents
       return AdminHeader::where('id',$adminHeader)->with('admin_contents')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminHeaderRequest  $request
     * @param  \App\Models\AdminHeader  $adminHeader
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminHeaderRequest $request, AdminHeader $adminHeader)
    {
        $adminHeader->update([
            'title' => $request->title,
            'user_id' => auth('sanctum')->user()->id ?? 0
        ]);

        return response()->json([
            'success' => 'Modification réussi',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminHeader  $adminHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy( $adminHeader)
    {
        //

        $el = AdminHeader::find($adminHeader);
        $el->delete();

        return response()->json([
            'response' =>  'Operation Réussi'
        ]);
    }
}

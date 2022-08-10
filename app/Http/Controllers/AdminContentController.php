<?php

namespace App\Http\Controllers;

use App\Models\AdminContent;
use App\Http\Requests\StoreAdminContentRequest;
use App\Http\Requests\UpdateAdminContentRequest;

class AdminContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return AdminContent::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdminContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminContentRequest $request)
    {
        AdminContent::create([
            'title' => $request->title,
            'title_en' =>  $request->title_en ?? articleTranslater($request->title),
            'description' => $request->description,
            'description_en' => $request->description_en ?? articleTranslater($request->description),
            'admin_header_id' => $request->admin_header_id,
            'user_id' => auth('sanctum')->user()->id,  
        ]);

        return response()->json([
            'success' => 'Enregistrement réussi'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminContent  $adminContent
     * @return \Illuminate\Http\Response
     */
    public function show(AdminContent $adminContent)
    {
        //
        return $adminContent;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminContentRequest  $request
     * @param  \App\Models\AdminContent  $adminContent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminContentRequest $request, AdminContent $adminContent)
    {
        $adminContent->update([
            'title' => $request->title,
            'title_en' => $request->title_en ??  articleTranslater($request->title),
            'description' => $request->description,
            'description_en' => $request->description_en ??  articleTranslater($request->description),
             
        ]);

        return response()->json([
            'success' => 'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminContent  $adminContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminContent $adminContent)
    {
        //
        $adminContent->delete();

        return response()->json([
            'success' => 'object deleted'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DownloawdDoc;
use App\Http\Requests\StoreDownloawdDocRequest;
use App\Http\Requests\UpdateDownloawdDocRequest;

class DownloawdDocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return DownloawdDoc::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDownloawdDocRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDownloawdDocRequest $request)
    {
        //
        DownloawdDoc::create([
            'title' => $request->title,
        ]);

        return response()->json([
            'success' => 'created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DownloawdDoc  $downloawdDoc
     * @return \Illuminate\Http\Response
     */
    public function show(DownloawdDoc $downloawdDoc)
    {
        //
        return $downloawdDoc;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDownloawdDocRequest  $request
     * @param  \App\Models\DownloawdDoc  $downloawdDoc
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDownloawdDocRequest $request, DownloawdDoc $downloawdDoc)
    {
        //
        $downloawdDoc->update(
            'title' => $request->title,
        );

         return response()->json([
            'update' => 'created'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DownloawdDoc  $downloawdDoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(DownloawdDoc $downloawdDoc)
    {
        //
        $downloawdDoc->delete();

        return response()->json([
            'success' => 'deleted'
        ]);
    }
}

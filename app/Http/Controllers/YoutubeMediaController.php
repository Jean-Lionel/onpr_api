<?php

namespace App\Http\Controllers;

use App\Models\YoutubeMedia;
use App\Http\Requests\StoreYoutubeMediaRequest;
use App\Http\Requests\UpdateYoutubeMediaRequest;

class YoutubeMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return YoutubeMedia::latest()->paginate(12);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreYoutubeMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreYoutubeMediaRequest $request)
    {
        YoutubeMedia::create($request->all());
        return response()->json([
            "success" => "youtube_media successfully"
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\YoutubeMedia  $youtubeMedia
     * @return \Illuminate\Http\Response
     */
    public function show(YoutubeMedia $youtubeMedia)
    {
        
        return $youtubeMedia;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateYoutubeMediaRequest  $request
     * @param  \App\Models\YoutubeMedia  $youtubeMedia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateYoutubeMediaRequest $request, YoutubeMedia $youtubeMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\YoutubeMedia  $youtubeMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(YoutubeMedia $youtubeMedia)
    {
        $youtubeMedia->delete();

        return response()->json([
            "success" => "YoutubeMedia deleted successfully"
        ]);
    }
}

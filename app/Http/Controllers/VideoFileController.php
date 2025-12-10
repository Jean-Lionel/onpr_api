<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoFileStoreRequest;
use App\Http\Requests\VideoFileUpdateRequest;
use App\Http\Resources\VideoFileCollection;
use App\Http\Resources\VideoFileResource;
use App\Models\VideoFile;
use Illuminate\Http\Request;

class VideoFileController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\VideoFileCollection
     */
    public function index(Request $request)
    {
        $videoFiles = VideoFile::all();

        return new VideoFileCollection($videoFiles);
    }

    /**
     * @param \App\Http\Requests\VideoFileStoreRequest $request
     * @return \App\Http\Resources\VideoFileResource
     */
    public function store(Request $request)
   {

        $request->validate([
            'file' => 'required|mimetypes:video/mp4,video/avi,video/mov|max:51200', // max 50MB
            'title' => 'required|string|max:255',
        ]);
        $video = new VideoFile();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/videos');
            $video->file_path = $path;
        }
        $video->title = $request->title;
        $video->save();
        return response()->json([
            "success" => "video uploaded successfully"
        ],200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VideoFile $videoFile
     * @return \App\Http\Resources\VideoFileResource
     */
    public function show(Request $request, VideoFile $videoFile)
    {
        return new VideoFileResource($videoFile);
    }

    /**
     * @param \App\Http\Requests\VideoFileUpdateRequest $request
     * @param \App\Models\VideoFile $videoFile
     * @return \App\Http\Resources\VideoFileResource
     */
    public function update(VideoFileUpdateRequest $request, VideoFile $videoFile)
    {
        $videoFile->update($request->validated());

        return new VideoFileResource($videoFile);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VideoFile $videoFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, VideoFile $videoFile)
    {
        $videoFile->delete();

        return response()->noContent();
    }
}

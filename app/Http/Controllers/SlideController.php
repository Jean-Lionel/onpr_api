<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use Image;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Slide::latest()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSlideRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSlideRequest $request)
    {

        if(!$request->hasFile("image")) {
            return response()->json(['upload_file_not_found'], 400);
        }

        $imageName = '';
        if (isset($request->image)) {
            # code...
            $file = $request->file("image"); 
            $allowedfileExtension=['jpeg','jpg','png','jpeg'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);

            if (!$check) {
            // code...
                return response()->json(
                    ['error' => 'Unknown extention type '], 400); 
             }
           
            $image = $request->file('image');
            $imageName = time() . '.'. $image->getClientOriginalExtension();

            $destinationPath  = public_path('img\slides');
            $imageFile = Image::make($image->getRealPath());

            $imageFile->resize(1100,537,function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath .'/'.   $imageName);

            // $destinationPath = public_path('/uploads');
            // $image->move($destinationPath, $imageName);
        }


        Slide::create([
             "title" => $request->title,
            "img_alt" => $request->img_alt,
            "image_caption" => $request->image_caption,
            "image_description" => $request->image_description,
            "image" => $imageName,
        ]);
       
       return response()->json([
        "success" => "Slide created successfully"
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {

        return $slide;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSlideRequest  $request
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlideRequest $request, Slide $slide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();

        return response()->json([
            "success" => "Slide deleted successfully"

        ]);
    }
}

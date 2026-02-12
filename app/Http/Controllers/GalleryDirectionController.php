<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryDirectionStoreRequest;
use App\Http\Requests\GalleryDirectionUpdateRequest;
use App\Http\Resources\GalleryDirectionCollection;
use App\Http\Resources\GalleryDirectionResource;
use App\Models\GalleryDirection;
use Illuminate\Http\Request;

class GalleryDirectionController extends Controller
{
    /**
     * Affiche toutes les entrées.
     */
    public function index(Request $request)
    {
        $galleryDirections = GalleryDirection::all();   

        return new GalleryDirectionCollection($galleryDirections);
    }

    /**
     * Enregistre une nouvelle entrée (avec upload d’image).
     */
    public function store(GalleryDirectionStoreRequest $request)
    {
        $data = $request->validated();

        // Gestion de l’image si envoyée
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Ensure the extension is preserved
            $extension = $image->getClientOriginalExtension(); 
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            
            $destinationPath = public_path('img/gallery_directions');
            
            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            $image->move($destinationPath, $imageName);
            $data['image'] = 'img/gallery_directions/' . $imageName;
        }

        $galleryDirection = GalleryDirection::create($data);

        return new GalleryDirectionResource($galleryDirection);
    }

    /**
     * Affiche une ressource unique.
     */
    public function show(Request $request, GalleryDirection $galleryDirection)
    {
        return new GalleryDirectionResource($galleryDirection);
    }

    /**
     * Met à jour une ressource existante.
     */
    public function update(GalleryDirectionUpdateRequest $request, GalleryDirection $galleryDirection)
    {
        $data = $request->validated();

        // Si nouvelle image, supprimer l’ancienne et enregistrer la nouvelle
        if ($request->hasFile('image')) {
            if ($galleryDirection->image) {
                // Since getImageAttribute adds full URL, we need to handle the raw attribute or check if it exists in public path
                // But here $galleryDirection->image comes from the model accessor? No, inside controller $galleryDirection->image is usually the raw attribute unless accessed via array/json.
                // Eloquent accessors are called when accessing the property. 
                // However, GalleryDirection methods might access raw attributes if not appended? 
                // Let's assume we need to deal with the stored path. 
                // BUT wait, I modified the model to have `getImageAttribute` which returns `url($value)`. 
                // So `$galleryDirection->image` will be the FULL URL. 
                // To get the relative path for unlink, I need the raw attribute. 
                // accessing `$galleryDirection->getRawOriginal('image')` is safer.

                $oldPath = public_path($galleryDirection->getRawOriginal('image'));
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            
            $destinationPath = public_path('img/gallery_directions');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0775, true);
            }

            $image->move($destinationPath, $imageName);
            $data['image'] = 'img/gallery_directions/' . $imageName;
        }

        $galleryDirection->update($data);

        return new GalleryDirectionResource($galleryDirection);
    }

    /**
     * Supprime une ressource et son image associée.
     */
    public function destroy(Request $request, GalleryDirection $galleryDirection)
    {
        // Supprime aussi le fichier image si présent
        if ($galleryDirection->image) {
            $path = public_path($galleryDirection->getRawOriginal('image'));
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        $galleryDirection->delete();

        return response()->noContent();
    }
}
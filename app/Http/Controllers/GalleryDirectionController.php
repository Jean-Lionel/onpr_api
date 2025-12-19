<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryDirectionStoreRequest;
use App\Http\Requests\GalleryDirectionUpdateRequest;
use App\Http\Resources\GalleryDirectionCollection;
use App\Http\Resources\GalleryDirectionResource;
use App\Models\GalleryDirection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $imageName = time() . '.'. $image->getClientOriginalExtension();
            $destinationPath  = public_path('img/gallery_directions');
            $image->move($destinationPath, $imageName.);
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
            if ($galleryDirection->image && Storage::disk('public')->exists($galleryDirection->image)) {
                Storage::disk('public')->delete($galleryDirection->image);
            }

            $path = $request->file('image')->store('gallery_directions', 'public');
            $data['image'] = $path;
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
        if ($galleryDirection->image && Storage::disk('public')->exists($galleryDirection->image)) {
            Storage::disk('public')->delete($galleryDirection->image);
        }

        $galleryDirection->delete();

        return response()->noContent();
    }
}
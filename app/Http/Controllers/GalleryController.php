<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Afficher la liste paginée des photos de la galerie
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $category = $request->get('category');

        $query = Gallery::latest();

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $galleries = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $galleries
        ]);
    }

    /**
     * Afficher une photo spécifique
     */
    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    /**
     * Créer une ou plusieurs nouvelles photos dans la galerie
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,jpg,png|max:5120', // 5MB max
        ], [
            'title.required' => 'Le titre est obligatoire',
            'images.required' => 'Au moins une image est requise',
            'images.*.image' => 'Le fichier doit être une image',
            'images.*.mimes' => 'Seuls les formats JPEG, JPG et PNG sont acceptés',
            'images.*.max' => 'La taille de l\'image ne doit pas dépasser 5MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $images = $request->file('images');
            $createdGalleries = [];

            foreach ($images as $image) {
                // Générer un nom unique pour l'image
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Stocker l'image dans le dossier public/gallery
                $imagePath = $image->storeAs('gallery', $imageName, 'public');

                // Créer l'entrée dans la base de données
                $gallery = Gallery::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'category' => $request->category,
                    'image' => Storage::url($imagePath),
                ]);

                $createdGalleries[] = $gallery;
            }

            return response()->json([
                'success' => true,
                'message' => count($createdGalleries) . ' photo(s) ajoutée(s) avec succès',
                'data' => $createdGalleries
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout des photos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour une photo de la galerie
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Mettre à jour les champs textuels
            if ($request->has('title')) {
                $gallery->title = $request->title;
            }
            if ($request->has('description')) {
                $gallery->description = $request->description;
            }
            if ($request->has('category')) {
                $gallery->category = $request->category;
            }

            // Si une nouvelle image est fournie
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image
                $oldImagePath = str_replace('/storage/', '', $gallery->image);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                // Stocker la nouvelle image
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('gallery', $imageName, 'public');
                $gallery->image = Storage::url($imagePath);
            }

            $gallery->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo mise à jour avec succès',
                'data' => $gallery
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une photo de la galerie
     */
    public function destroy($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            // Supprimer l'image du stockage
            $imagePath = str_replace('/storage/', '', $gallery->image);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Supprimer l'entrée de la base de données
            $gallery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Photo supprimée avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir toutes les catégories disponibles
     */
    public function getCategories()
    {
        $categories = Gallery::whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PhotoWeek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhotoWeekController extends Controller
{
    /**
     * Afficher la liste paginée des photos
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $photos = PhotoWeek::latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $photos
        ]);
    }

    /**
     * Obtenir la photo active de la semaine (la plus récente)
     */
    public function active()
    {
        $photo = PhotoWeek::latest()->first();

        return response()->json([
            'success' => true,
            'data' => $photo
        ]);
    }

    /**
     * Afficher une photo spécifique
     */
    public function show($id)
    {
        $photo = PhotoWeek::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $photo
        ]);
    }

    /**
     * Créer une nouvelle photo de la semaine
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'week_range' => 'nullable|string|max:255',
            'photographer' => 'nullable|string|max:255',
        ], [
            'title.required' => 'Le titre est obligatoire',
            'image.required' => 'L\'image est obligatoire',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'Formats acceptés: JPEG, JPG, PNG, WEBP',
            'image.max' => 'La taille de l\'image ne doit pas dépasser 5MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Upload de l'image
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('photo-week', $imageName, 'public');

            $photo = PhotoWeek::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => Storage::url($imagePath),
                'week_range' => $request->week_range,
                'photographer' => $request->photographer,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo de la semaine créée avec succès',
                'data' => $photo
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour une photo de la semaine
     */
    public function update(Request $request, $id)
    {
        $photo = PhotoWeek::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'week_range' => 'nullable|string|max:255',
            'photographer' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'title' => $request->title ?? $photo->title,
                'description' => $request->description ?? $photo->description,
                'week_range' => $request->week_range ?? $photo->week_range,
                'photographer' => $request->photographer ?? $photo->photographer,
            ];

            // Si une nouvelle image est fournie
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image
                $oldImagePath = str_replace('/storage/', '', $photo->image);
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                // Stocker la nouvelle image
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('photo-week', $imageName, 'public');
                $data['image'] = Storage::url($imagePath);
            }

            $photo->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Photo mise à jour avec succès',
                'data' => $photo
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
     * Supprimer une photo de la semaine
     */
    public function destroy($id)
    {
        try {
            $photo = PhotoWeek::findOrFail($id);

            // Supprimer l'image du stockage
            $imagePath = str_replace('/storage/', '', $photo->image);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $photo->delete();

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
}

<?php

namespace App\Http\Controllers;

use App\Models\Brief;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BriefController extends Controller
{
    /**
     * Afficher la liste paginée des brèves
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search');

        $query = Brief::orderBy('published_at', 'desc')
                     ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        $briefs = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $briefs
        ]);
    }

    /**
     * Afficher une brève spécifique
     */
    public function show($id)
    {
        $brief = Brief::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $brief
        ]);
    }

    /**
     * Créer une nouvelle brève
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'source' => 'nullable|string|max:255',
            'published_at' => 'required|date',
        ], [
            'title.required' => 'Le titre est obligatoire',
            'content.required' => 'Le contenu est obligatoire',
            'published_at.required' => 'La date de publication est obligatoire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $brief = Brief::create([
                'title' => $request->title,
                'content' => $request->content,
                'source' => $request->source,
                'published_at' => $request->published_at,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Brève créée avec succès',
                'data' => $brief
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la brève',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour une brève
     */
    public function update(Request $request, $id)
    {
        $brief = Brief::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'source' => 'nullable|string|max:255',
            'published_at' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $brief->update($request->only([
                'title',
                'content',
                'source',
                'published_at'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Brève mise à jour avec succès',
                'data' => $brief
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
     * Supprimer une brève (soft delete)
     */
    public function destroy($id)
    {
        try {
            $brief = Brief::findOrFail($id);
            $brief->delete();

            return response()->json([
                'success' => true,
                'message' => 'Brève supprimée avec succès'
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
     * Obtenir les brèves récentes
     */
    public function recent(Request $request)
    {
        $limit = $request->get('limit', 10);

        $briefs = Brief::where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $briefs
        ]);
    }

    /**
     * Obtenir les brèves du jour
     */
    public function today()
    {
        $briefs = Brief::whereDate('published_at', today())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $briefs
        ]);
    }
}

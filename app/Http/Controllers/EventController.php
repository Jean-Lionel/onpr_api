<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Afficher la liste paginée des événements
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $category = $request->get('category');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Event::orderBy('date', 'asc')->orderBy('time', 'asc');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $events = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Afficher un événement spécifique
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    /**
     * Créer un nouvel événement
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
        ], [
            'title.required' => 'Le titre est obligatoire',
            'date.required' => 'La date est obligatoire',
            'time.required' => 'L\'heure est obligatoire',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $request->time,
                'location' => $request->location,
                'category' => $request->category,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Événement créé avec succès',
                'data' => $event
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'événement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un événement
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required',
            'location' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $event->update($request->only([
                'title',
                'description',
                'date',
                'time',
                'location',
                'category'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Événement mis à jour avec succès',
                'data' => $event
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
     * Supprimer un événement
     */
    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Événement supprimé avec succès'
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
     * Obtenir les événements à venir
     */
    public function upcoming(Request $request)
    {
        $limit = $request->get('limit', 10);

        $events = Event::where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Obtenir toutes les catégories
     */
    public function getCategories()
    {
        $categories = Event::whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}

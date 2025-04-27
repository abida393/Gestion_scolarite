<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evenement;
use Carbon\Carbon;

class EvenementController extends Controller
{
    /**
     * Récupérer tous les événements.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
{
    try {
        $evenements = Evenement::all()->map(function ($evenement) {
            return [
                'id' => $evenement->id,
                'title' => $evenement->titre, // Assurez-vous que 'titre' contient le texte de l'événement
                'start' => $evenement->date . 'T' . $evenement->heure_debut,
                'end' => $evenement->date . 'T' . $evenement->heure_fin,
                'color' => $evenement->color ?? '#007bff' // Couleur par défaut si non spécifiée
            ];
        });

        return response()->json($evenements, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la récupération des événements.'], 500);
    }
}

/* Removed misplaced JavaScript code */
    /**
     * Enregistrer un nouvel événement.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'start' => 'required|date',
        'end' => 'required|date|after:start',
        'color' => 'nullable|string' // Valider la couleur
    ]);

    try {
        $evenement = Evenement::create([
            'titre' => $validatedData['title'],
            'date' => date('Y-m-d', strtotime($validatedData['start'])),
            'heure_debut' => date('H:i:s', strtotime($validatedData['start'])),
            'heure_fin' => date('H:i:s', strtotime($validatedData['end'])),
            'color' => $validatedData['color'] ?? '#007bff' // Couleur par défaut si non spécifiée
        ]);

        return response()->json($evenement, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la création de l\'événement.'], 500);
    }
}
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'start' => 'required|date',
        'end' => 'nullable|date|after_or_equal:start'
    ]);

    try {
        $evenement = Evenement::findOrFail($id);
        $evenement->date = date('Y-m-d', strtotime($validatedData['start']));
        $evenement->heure_debut = date('H:i:s', strtotime($validatedData['start']));
        $evenement->heure_fin = $validatedData['end'] ? date('H:i:s', strtotime($validatedData['end'])) : null;
        $evenement->save();

        return response()->json(['success' => true], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la mise à jour de l\'événement.'], 500);
    }
}
public function destroy($id)
{
    try {
        $evenement = Evenement::findOrFail($id);
        $evenement->delete();

        return response()->json(['success' => true], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la suppression de l\'événement.'], 500);
    }
}

    /**
     * Afficher la vue du calendrier.
     *
     * @return \Illuminate\View\View
     */
    public function afficherEvenements()
{
    $evenements = Evenement::all();

    return view('etudiant.evenements', compact('evenements'));
}

    public function showCalendar()
    {
        return view('calendar');
    }
}

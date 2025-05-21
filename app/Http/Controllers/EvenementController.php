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




    public function afficherEvenementsResponsable()
{
    $evenements = Evenement::all(); // Tu peux filtrer plus tard si nécessaire
    return view('responsable.evenement', compact('evenements'));
}

public function addEvent(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'start' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
    ]);

    try {
        Evenement::create([
            'titre' => $validatedData['title'],
            'date' => $validatedData['start'],
            'heure_debut' => date('H:i', strtotime($validatedData['start_time'])),  // Format H:i (heure et minute)
            'heure_fin' => date('H:i', strtotime($validatedData['end_time'])),      // Format H:i (heure et minute)
        ]);

        return redirect()->route('responsable.events')->with('message', 'Événement ajouté avec succès.');
    } catch (\Exception $e) {
        \Log::error('Erreur lors de la création de l\'événement: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors de la création de l\'événement: ' . $e->getMessage());
    }
}



public function updateEvent(Request $request, $id)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'start' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i',
    ]);

    try {
        $evenement = Evenement::findOrFail($id);
        $evenement->titre = $validatedData['title'];
        $evenement->date = $validatedData['start'];
        $evenement->heure_debut = $validatedData['start_time'];
        $evenement->heure_fin = $validatedData['end_time'];
        $evenement->save();

        return redirect()->route('responsable.events')->with('message', 'Événement modifié avec succès');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'événement.');
    }
}



public function deleteEvent($id)
{
    try {
        $evenement = Evenement::findOrFail($id);
        $evenement->delete();

        return redirect()->route('responsable.events')->with('message', 'Événement supprimé avec succès');
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la suppression de l\'événement.'], 500);
    }
}

}

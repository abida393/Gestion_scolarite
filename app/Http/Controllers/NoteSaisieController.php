<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Filiere;
use App\Models\Module;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use App\Models\Note;

class NoteSaisieController extends Controller
{
    // Affiche la page de saisie des notes
    public function notesAdmin()
    {
        $filieres = Filiere::all();
        return view('responsable.notes-admin', compact('filieres'));
    }

    // Récupère les classes selon la filière
    public function getClasses($filiere_id)
    {
        return Classe::where('filieres_id', $filiere_id)->get();
    }

    // Récupère les modules selon la classe
    public function getModules($classe_id)
    {
        return Module::where('classe_id', $classe_id)->get();
    }

    // Récupère les matières selon le module
    public function getMatieres($module_id)
    {
        return Matiere::where('module_id', $module_id)->get();
    }

    // Récupère les étudiants selon la classe
    public function getEtudiants($classe_id)
    {
        return Etudiant::where('classes_id', $classe_id)->get();
    }

    // Enregistre ou met à jour les notes saisies
    public function store(Request $request)
{
    $matiereId = $request->matiere_id;
    $examNumber = $request->exam_number;

    foreach ($request->notes as $etudiantId => $noteValue) {
        // Récupération ou création de la note
        $note = Note::firstOrNew([
            'etudiant_id' => $etudiantId,
            'matiere_id' => $matiereId,
        ]);

        // Saisie de note1 ou note2
        if ($examNumber == 1 && isset($noteValue["note1"])) {
            $note->note1 = (double)$noteValue["note1"];
        }

        if ($examNumber == 2 && isset($noteValue["note2"])) {
            $note->note2 = (double)$noteValue["note2"];
        }

        // Enregistrer d'abord la note partielle avant le calcul
        $note->save();

        // On recharge la note pour avoir les deux valeurs actuelles
        $note = Note::where('etudiant_id', $etudiantId)
                    ->where('matiere_id', $matiereId)
                    ->first();

    }

    return redirect()->back()->with('success', 'Notes enregistrées avec succès.');
}
public function afficheNotes($classe_id, $matiere_id)
{
    $etudiants = Etudiant::where('classes_id', $classe_id)->get();

    $resultats = $etudiants->map(function ($etudiant) use ($matiere_id) {
        $note = Note::where('etudiant_id', $etudiant->id)->where('matiere_id', $matiere_id)->first();
        return [
            'nom' => $etudiant->etudiant_nom,
            'prenom' => $etudiant->etudiant_prenom,
            'note1' => $note->note1 ?? null,
            'note2' => $note->note2 ?? null,
            'note_finale' => $note->note_finale ?? null,
        ];
    });

    return response()->json($resultats);
}

// Ajoutez ces méthodes à votre NoteSaisieController

public function edit($etudiant_id, $matiere_id)
{
    $note = Note::where('etudiant_id', $etudiant_id)
                ->where('matiere_id', $matiere_id)
                ->firstOrFail();
    
    return response()->json($note);
}

public function update(Request $request)
{
    $request->validate([
        'note1' => 'nullable|numeric|between:0,20',
        'note2' => 'nullable|numeric|between:0,20'
    ]);

    $note = Note::where('etudiant_id', $request->etudiant_id)
                ->where('matiere_id', $request->matiere_id)
                ->firstOrFail();

    if ($request->has('note1')) {
        $note->note1 = $request->note1;
    }

    if ($request->has('note2')) {
        $note->note2 = $request->note2;
    }

    $note->save();

    return response()->json(['success' => 'Note mise à jour avec succès']);
}
     
}

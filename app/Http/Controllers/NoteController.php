<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Module;
use App\Models\Matiere;
use App\Models\Note;

class NoteController extends Controller
{
    
public function afficherNotes($etudiantId)
{
    // Récupérer l'étudiant
    $etudiant = Etudiant::findOrFail($etudiantId);

    // Vérifier si l'étudiant a une classe associée
    if (!$etudiant->classe_id) {
        abort(404, 'Classe non trouvée pour cet étudiant.');
    }

    // Récupérer tous les modules associés à la classe de l'étudiant
    $modules = Module::where('classe_id', $etudiant->classe_id)
        ->with(['matieres.notes' => function ($query) use ($etudiantId) {
            $query->where('etudiant_id', $etudiantId);
        }])
        ->get();

    // Vérifier si des modules ont été trouvés
    if ($modules->isEmpty()) {
        abort(404, 'Aucun module trouvé pour cette classe.');
    }

    // Retourner la vue avec les données
    return view('note', compact('etudiant', 'modules'));
}
}

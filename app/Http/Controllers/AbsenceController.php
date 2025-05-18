<?php

namespace App\Http\Controllers;

use App\Models\EtudiantAbsence;
use App\Models\Classe;
use App\Models\Seance;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\etudiant_absence;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = EtudiantAbsence::with('seance.matiere')->get();
        return view('absences', compact('absences'));
    }

    public function justifier(Request $request)
    {
        $request->validate([
            'absence_id' => 'required|exists:etudiant_absences,id',
            'justification' => 'required|string',
        ]);

        $absence = EtudiantAbsence::findOrFail($request->absence_id);

        if ($request->hasFile('justification_file')) {
            $file = $request->file('justification_file');
            $filePath = $file->store('justifications');
            $absence->update([
                'justification' => $request->justification,
                'justification_file' => $filePath,
                'date_justif' => now(),
            ]);
        } else {
            $absence->update([
                'justification' => $request->justification,
                'date_justif' => now(),
            ]);
        }

        return back()->with('success', 'Justification envoyée avec succès.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'absence_id' => 'required|exists:etudiant_absences,id',
            'justification' => 'required|string',
        ]);

        $absence = EtudiantAbsence::findOrFail($request->absence_id);

        $absence->update([
            'justification' => $request->justification,
            'date_justif' => now(),  // Mettre la date d'aujourd'hui
        ]);

        return back()->with('success', 'Justification envoyée avec succès.');
    }

    public function indexResponsable()
    {
        // Récupérer toutes les classes
        $classes = Classe::all();

        // Récupérer toutes les séances (ou tu peux filtrer par classe ou par matière, selon ta logique)
        $seances = Seance::all(); // Assurez-vous que Seance est bien importé et que ta table de séances existe

        // Récupérer les absences
        $absences = etudiant_absence::with('seance.matiere', 'etudiant')->get();


        // Retourner la vue avec les données nécessaires
        return view('responsable.absences', compact('absences', 'classes', 'seances'));
    }

    // Ajouter une absence (par le responsable)
    public function createAbsence(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'seance_id' => 'required|exists:seances,id',
            'date_absence' => 'required|date',
        ]);

        EtudiantAbsence::create([
            'etudiant_id' => $request->etudiant_id,
            'seance_id' => $request->seance_id,
            'date_absence' => $request->date_absence,
            'justification' => '',
            'justification_file' => '',
            'justifier' => false,
        ]);

        return back()->with('success', 'Absence ajoutée avec succès.');
    }

    // Mettre à jour l'état de justification par le responsable
    public function updateEtat($id)
    {
        $absence = EtudiantAbsence::findOrFail($id);
        $absence->update([
            'justifier' => true
        ]);

        return back()->with('success', 'État de justification mis à jour.');
    }

    // Méthode pour récupérer les étudiants par classe
    public function getEtudiantsByClasse($classe_id)
    {
        // Récupérer les étudiants de la classe spécifiée
        $etudiants = Etudiant::where('classe_id', $classe_id)->get();

        // Retourner la réponse (par exemple, une vue ou JSON)
        return response()->json($etudiants);
    }
}
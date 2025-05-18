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
        $absences = etudiant_absence::with('seance.matiere')->get();
        return view('responsable.absences', compact('absences'));
    }

    public function justifier(Request $request)
    {
        $request->validate([
            'absence_id' => 'required|exists:etudiant_absences,id',
            'justification' => 'required|string',
        ]);

        $absence = etudiant_absence::findOrFail($request->absence_id);

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

        $absence = etudiant_absence::findOrFail($request->absence_id);

        $absence->update([
            'justification' => $request->justification,
            'date_justif' => now(),  // Mettre la date d'aujourd'hui
        ]);

        return back()->with('success', 'Justification envoyée avec succès.');
    }


    // Ajouter par Imad
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
}

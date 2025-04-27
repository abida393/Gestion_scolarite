<?php

namespace App\Http\Controllers;

use App\Models\EtudiantAbsence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\etudiant_absence;

class AbsenceController extends Controller
{
    public function index()
    {
       
        $absences = Absence::with('seance.matiere')->get();
        return view('absences', compact('absences'));
    }
    public function justifier(Request $request)
    {
        $request->validate([
            'absence_id' => 'required|exists:etudiant_absences,id',
            'justification' => 'required|string',
        ]);

        $absence = etudiant_absence::findOrFail($request->absence_id);

        $absence->update([
            'justification' => $request->justification,
            'date_justif' => now(),  // date aujourd'hui
        ]);

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
}


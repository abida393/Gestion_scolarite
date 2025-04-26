<?php

namespace App\Http\Controllers;

use App\Models\EtudiantAbsence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenceController extends Controller
{
    public function index()
    {
       
        $absences = Absence::with('seance.matiere')->get();
        return view('absences', compact('absences'));
    }

    public function justify(Request $request)
    {
        $absence = Absence::findOrFail($id);

        $absence->update([
            'justification' => $request->input('justification'),
            'justifier' => false, // En cours de validation
        ]);

        return redirect()->back()->with('success', 'Justification envoyée.');
    }
}


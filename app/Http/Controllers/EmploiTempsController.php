<?php

namespace App\Http\Controllers;

use App\Models\emplois_temps;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\Classe;
use Illuminate\Http\Request;

class EmploiTempsController extends Controller
{
    public function emploi()
    {
        $emploisTemps = emplois_temps::all();
        return view('Emploi.emploi', compact('emploisTemps'));
    }

    public function create()
    {
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        $classes = Classe::all();
        return view('Emploi.create_emploi', compact('matieres', 'enseignants', 'classes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jour' => 'required|string|max:255',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'salle' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
        ]);

        emplois_temps::create($validatedData);
        return redirect()->route('emploi')->with('success', 'Emploi du temps ajouté.');
    }

    public function edit_emploi(emplois_temps $timetable)
    {
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        $classes = Classe::all();
        return view('edit_emploi', [
            'emploiTemp' => $timetable,
            'matieres' => $matieres,
            'enseignants' => $enseignants,
            'classes' => $classes
        ]);
    }

    public function update(Request $request, emplois_temps $timetable)
    {
        $validatedData = $request->validate([
            'jour' => 'required|string|max:255',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'salle' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
        ]);

        $timetable->update($validatedData);
        return redirect()->route('emploi')->with('success', 'Emploi du temps mis à jour.');
    }

    public function destroy(emplois_temps $timetable)
    {
        $timetable->delete();
        return redirect()->route('emploi')->with('success', 'Emploi du temps supprimé.');
    }
}
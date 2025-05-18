<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\emplois_temps;
use App\Models\EmploiTemps;
use App\Models\Etudiant;
use App\Models\etudiant_absence;
use App\Models\EtudiantAbsence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsencesExport;
use Carbon\Carbon;

class AbsenceResponsableController extends Controller
{
    public function index()
    {
        $absences = etudiant_absence::with(['etudiant', 'matiere', 'classe', 'emploiTemps.matiere'])
         
        ->orderBy('date_absence', 'desc')
            ->paginate(20);

        return view('responsable.absences', compact('absences'));
    }

    public function justificationsEnAttente()
    {
        $justifications = etudiant_absence::with(['etudiant', 'matiere', 'classe'])
            ->where('status', 'pending')
            ->orderBy('date_justif', 'desc')
            ->paginate(20);

        return view('responsable.justifications_pending', compact('justifications'));
    }

    public function create()
    {
        $etudiants = Etudiant::orderBy('etudiant_nom')->get();
        $emplois = emplois_temps::with(['matiere', 'classe'])->get();
    //   dd(   $emplois);
        $classes = Classe::all();
       
        return view('responsable.create_Edit_Form_Absence', compact('classes', 'etudiants', 'emplois'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'etudiant_id' => 'required|exists:etudiants,id',
        'emploi_temps_id' => 'required|exists:emplois_temps,id',
        'date_absence' => 'required|date',
        'type' => 'required|in:absence,retard',
        'duree_minutes' => 'nullable|integer|required_if:type,retard',
        'justification' => 'nullable|string',
        'justification_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
    ]);

    if ($request->hasFile('justification_file')) {
        $path = $request->file('justification_file')->store('justificatifs', 'public');
        $validated['justification_file'] = $path;
        $validated['Justifier'] = true;
    }

    etudiant_absence::create($validated);

    return redirect()->route('responsable.absences')->with('success', 'Absence enregistrée avec succès.');
}

public function edit(etudiant_absence $absence)
{
    $etudiants = Etudiant::orderBy('etudiant_nom')->get();
    $emplois = emplois_temps::with(['matiere', 'classe'])->get();
    $classes = Classe::all();
    // Ici, on passe l'absence unique
    return view('responsable.create_Edit_Form_Absence', compact('absence', 'etudiants', 'emplois', 'classes'));
}

    public function update(Request $request, etudiant_absence $absence)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'emploi_temps_id' => 'required|exists:emplois_temps,id',
            'date_absence' => 'required|date',
            'type' => 'required|in:absence,retard',
            'duree_minutes' => 'nullable|integer|required_if:type,retard',
            'justification' => 'nullable|string',
            'justification_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('justification_file')) {
            if ($absence->justification_file) {
                Storage::disk('public')->delete($absence->justification_file);
            }
            
            $path = $request->file('justification_file')->store('justificatifs/responsable', 'public');
            $validated['justification_file'] = $path;
            $validated['Justifier'] = true;
            $validated['status'] = 'approved';
        }

        $absence->update($validated);

        return redirect()->route('responsable.absences')->with('success', 'Absence mise à jour avec succès.');
    }

    public function validerJustification(Request $request, etudiant_absence $absence)
    {
        $request->validate([
            'action' => 'required|in:accept,reject,non_justifier',
            'commentaire' => 'nullable|string|max:255'
        ]);

        if ($request->action === 'accept') {
            $absence->update([
                'Justifier' => true,
                'status' => 'approved',
                'validated_at' => Carbon::now(),
                // 'commentaire_responsable' => $request->commentaire
            ]);

            return back()->with('success', 'Justification validée avec succès.');
        } elseif ($request->action === 'reject') {
            if ($absence->justification_file) {
                Storage::disk('public')->delete($absence->justification_file);
            }

            $absence->update([
                'justification' => null,
                'justification_file' => null,
                'Justifier' => false,
                'status' => 'rejected',
                // 'commentaire_responsable' => $request->commentaire
            ]);

            return back()->with('success', 'Justification rejetée.');
        } elseif ($request->action === 'non_justifier') {
            $absence->update([
                'Justifier' => false,
                'status' => 'non_justifier',
                'validated_at' => Carbon::now(),
                // 'commentaire_responsable' => $request->commentaire
            ]);

            return back()->with('success', 'Absence marquée comme non justifiée.');
        }
    }

    public function downloadJustificatif($id)
    {
        $absence = etudiant_absence::findOrFail($id);
        
        if (!$absence->justification_file) {
            abort(404);
        }

        return Storage::disk('public')->download($absence->justification_file);
    }

    public function export()
    {
        return Excel::download(new AbsencesExport, 'absences-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function destroy(etudiant_absence $absence)
    {
        if ($absence->justification_file) {
            Storage::disk('public')->delete($absence->justification_file);
        }
        
        $absence->delete();
        
        return back()->with('success', 'Absence supprimée avec succès.');
    }

    public function getEtudiantsParClasse($classeId)
    {
        $etudiants = Etudiant::where('classes_id', $classeId)
                     ->select('id', 'etudiant_nom as nom', 'etudiant_prenom as prenom')
                     ->get();
        return response()->json($etudiants);
    }

   
public function getSeancesParClasse($classeId)
{
    // On ne filtre plus par classe_id car la colonne n'existe pas
    $seances = emplois_temps::with(['matiere'])
        ->select(
            'id',
            'heure_debut',
            'heure_fin',
            'matiere_id',
            'date',
            'salle'
        )
        ->get()
        ->map(function ($seance) {
            return [
                'id' => $seance->id,
                'heure_debut' => $seance->heure_debut,
                'heure_fin' => $seance->heure_fin,
                'matiere' => $seance->matiere ? $seance->matiere->nom_matiere : 'Inconnue',
            ];
        });
    return response()->json($seances);
}
}
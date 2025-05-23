<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\emplois_temps;
use App\Models\EmploiTemps;
use App\Models\enseignant;
use App\Models\Etudiant;
use App\Models\etudiant_absence;
use App\Models\EtudiantAbsence;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsencesExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsenceResponsableController extends Controller
{
 public function index($request = null)
{
    $request = $request ?? request();
    $classes = Classe::with('etudiants')->get();
    $modules = Matiere::all();
    $professeurs = enseignant::all();

   $query = etudiant_absence::query();

    if ($request->filled('classe_id')) {
        $query->whereHas('etudiant', function($q) use ($request) {
            $q->where('classes_id', $request->classe_id);
        });
    }
    if ($request->filled('etudiant_id')) {
        $query->where('etudiant_id', $request->etudiant_id);
    }
  // AJOUT : filtre par statut
    if ($request->filled('status')) {
        if ($request->status == 'justified') {
            $query->where('Justifier', true);
        } elseif ($request->status == 'pending') {
            $query->where('status', 'pending');
        } elseif ($request->status == 'unjustified') {
            $query->where('Justifier', false)->where('status', '!=', 'pending');
        } else {
            $query->where('status', $request->status);
        }
    }
    // AJOUT : filtre par type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    // Statistiques
    $totalAbsences = (clone $query)->count();
    $justifiedAbsences = (clone $query)->where('Justifier', true)->count();
    $pendingAbsences = (clone $query)->where('status', 'pending')->count();
    $unjustifiedAbsences = (clone $query)->where('Justifier', false)->where('status', '!=', 'pending')->count();

    $absences = $query->paginate(20)->appends(request()->query());

    // Tendance des absences sur 30 jours
    $startDate = now()->subDays(29)->startOfDay();
    $endDate = now()->endOfDay();
    $absencesByDay = (clone $query)
        ->whereBetween('date_absence', [$startDate, $endDate])
        ->get()
        ->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->date_absence)->format('Y-m-d');
        });
       

    $absenceTrends = [];
    $max = 0;
    for ($i = 0; $i < 30; $i++) {
    $date = now()->subDays(29 - $i)->format('Y-m-d');
    $count = isset($absencesByDay[$date]) ? count($absencesByDay[$date]) : 0;
    $absenceTrends[] = [
        'date' => $date,
        'day' => Carbon::parse($date)->format('d/m'),
        'count' => $count,
    ];
    if ($count > $max) $max = $count;
}

    foreach ($absenceTrends as &$trend) {
        $trend['percentage'] = $max > 0 ? ($trend['count'] / $max) * 100 : 0;
    }

    // Top 5 classes avec le plus d'absences cette semaine
    $weekStart = now()->startOfWeek();
    $weekEnd = now()->endOfWeek();
    $topClasses = Classe::withCount(['etudiants as absences_count' => function($query) use ($weekStart, $weekEnd) {
        $query->join('etudiant_absences', 'etudiants.id', '=', 'etudiant_absences.etudiant_id')
              ->whereBetween('etudiant_absences.date_absence', [$weekStart, $weekEnd]);
    }])
    ->orderByDesc('absences_count')
    ->take(5)
    ->get();

    $maxClassAbsences = $topClasses->max('absences_count') ?: 1; // éviter division par zéro

    return view('responsable.absences', compact(
        'absences',
        'classes',
        'modules',
        'professeurs',
        'totalAbsences',
        'justifiedAbsences',
        'pendingAbsences',
        'unjustifiedAbsences',
        'absenceTrends',
        'topClasses',
        'maxClassAbsences'
    ));
}
public function bulkAction(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:absences,id',
        'action' => 'required|in:justify,delete'
    ]);

    try {
        switch ($request->action) {
            case 'justify':
               etudiant_absence::whereIn('id', $request->ids)
                    ->where('etudiant_id', auth('etudiant')->id())
                    ->update(['status' => 'pending']);
                break;
                
            case 'delete':
                etudiant_absence::whereIn('id', $request->ids)
                    ->where('etudiant_id', auth('etudiant')->id())
                    ->delete();
                break;
        }

        return response()->json(['success' => true]);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false], 500);
    }
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

public function exportCSV(Request $request)
{
    $absences = etudiant_absence::with(['etudiant', 'emploiTemps.matiere'])
        ->when($request->classe_id, function($query) use ($request) {
            return $query->whereHas('etudiant', function($q) use ($request) {
                $q->where('classes_id', $request->classe_id);
            });
        })
        ->when($request->etudiant_id, function($query) use ($request) {
            return $query->where('etudiant_id', $request->etudiant_id);
        })
        ->get();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="absences.csv"',
    ];

    $callback = function() use ($absences) {
        $file = fopen('php://output', 'w');
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        // En-têtes CSV
        fputcsv($file, ['Nom', 'Prénom', 'Matière', 'Date', 'Heure', 'Type', 'Statut']);
        foreach ($absences as $absence) {
            fputcsv($file, [
                $absence->etudiant->etudiant_nom,
                $absence->etudiant->etudiant_prenom,
                $absence->emploiTemps->matiere->nom_matiere ?? 'Inconnue',
                \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y'),
                $absence->emploiTemps && $absence->emploiTemps->heure_debut && $absence->emploiTemps->heure_fin
                    ? \Carbon\Carbon::parse($absence->emploiTemps->heure_debut)->format('H:i') . ' - ' . \Carbon\Carbon::parse($absence->emploiTemps->heure_fin)->format('H:i')
                    : 'Inconnu',
                $absence->type === 'retard' ? 'Retard' : 'Absence',
                $absence->Justifier ? 'Justifiée' : ($absence->status === 'pending' ? 'En attente' : 'Non justifiée'),
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}



public function exportPDF(Request $request)
{
     $absences = etudiant_absence::with(['etudiant', 'emploiTemps.matiere'])
        ->when($request->classe_id, function($query) use ($request) {
            return $query->whereHas('etudiant', function($q) use ($request) {
                $q->where('classes_id', $request->classe_id);
            });
        })
        ->when($request->etudiant_id, function($query) use ($request) {
            return $query->where('etudiant_id', $request->etudiant_id);
        })
        ->get();

    $pdf = Pdf::loadView('responsable.absences-pdf', [
        'absences' => $absences,
        'classe' => $request->classe_id ? Classe::find($request->classe_id) : null
    ]);

    return $pdf->download('absences_' . now()->format('Y-m-d_H-i') . '.pdf');
}
}
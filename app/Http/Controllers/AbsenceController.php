<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\emplois_temps;
use App\Models\etudiant_absence;
use App\Models\EtudiantAbsence;
use App\Models\seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsenceController extends Controller
{
 public function index()
{
    $absences = etudiant_absence::with(['matiere', 'classe', 'emploiTemps'])
        ->where('etudiant_id', Auth::id())
        ->orderBy('date_absence', 'desc')
        ->paginate(10);

 $monthlyTrends = etudiant_absence::selectRaw("DATE_FORMAT(date_absence, '%Y-%m') as month, COUNT(*) as count")
        ->where('etudiant_id', Auth::id())
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    return view('etudiant.absence_justif', compact('absences', 'monthlyTrends'));
}
public function details($id)
{
    $absence = etudiant_absence::with(['emploiTemps.matiere'])
        ->where('id', $id)
        ->where('etudiant_id', \Auth::id())
        ->firstOrFail();

    return view('etudiant.absence_details', compact('absence'));
}
   public function justifier(Request $request)
{
    $request->validate([
        'absence_id' => 'required|exists:etudiant_absences,id',
        'justification' => 'required|string',
'justification_file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048', // Limite de 2 Mo
    ]);

    // Vérifier que l'absence appartient à l'étudiant connecté
    $absences = etudiant_absence::with(['matiere', 'classe', 'emploiTemps'])
    ->where('etudiant_id', Auth::id())
    ->orderBy('date_absence', 'desc')
    ->paginate(10);

    // Stockage du fichier
    $path = $request->file('justification_file')->store(
        'justificatifs/etudiant_'.Auth::guard('etudiant')->id(),
        'public'
    );

    // Récupérer l'absence à justifier
    $absence = etudiant_absence::where('id', $request->absence_id)
        ->where('etudiant_id', Auth::id())
        ->firstOrFail();

    $absence->update([
        'justification' => $request->justification,
    'justification_file' => $path,
    'status' => 'pending',
    'Justifier' => false, // Ajoute cette ligne
    'date_justif' => now()
]);

    return back()->with('success', 'Votre justification a été soumise avec succès.');
}

    public function downloadJustificatif($id)
    {
        $absences = etudiant_absence::with('seance.matiere')->get();
        return view('responsable.absences', compact('absences'));
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
        $seances = seance::all(); // Assurez-vous que Seance est bien importé et que ta table de séances existe

        // Récupérer les absences
        $absences = etudiant_absence::with('seance.matiere', 'etudiant')->get();


        // Retourner la vue avec les données nécessaires
        return view('responsable.absences', compact('absences', 'classes', 'seances'));
        $absence = etudiant_absence::where('id', $id)
            ->where('etudiant_id', Auth::id())
            ->firstOrFail();

        if (!$absence->justification_file) {
            abort(404);
        }

        return Storage::disk('public')->download($absence->justification_file);
    }
}

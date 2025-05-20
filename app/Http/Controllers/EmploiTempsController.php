<?php

namespace App\Http\Controllers;

use App\Models\emplois_temps;
use App\Models\EmploiTemps;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Formation;
use App\Models\Matiere;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class EmploiTempsController extends Controller
{
  public function affich(Request $request)
    {
        // Récupération des paramètres de filtrage
        $formationId = $request->input('formation_id');
        $filiereId = $request->input('filiere_id');
        $classeId = $request->input('classe_id');

        // Requête pour les classes avec relations
        $classesQuery = Classe::with(['filiere', 'filiere.formation']);
        // Filtrage des classes
        if ($formationId) {

            $classesQuery->whereHas('filiere', function($q) use ($formationId) {
                $q->where('formation_id', $formationId);
            });
        }

        if ($filiereId) {
    $classesQuery->where('filieres_id', $filiereId);
}

        $classes = $classesQuery->get();

        // Requête pour les emplois du temps
        $emploisQuery = emplois_temps::with(['matiere', 'enseignant', 'classe']);

        if ($classeId) {
            $emploisQuery->where('classe_id', $classeId);
        }

        $emploisTemps = $emploisQuery->orderBy('jour')->orderBy('heure_debut')->get();

        // Autres données nécessaires pour la vue
        $formations = Formation::all();
        $filieres = Filiere::all();
        $enseignantsCount = Enseignant::count();
        $conflitsCount = $this->detectConflicts($emploisTemps);
        $coursSemaine = $emploisTemps->filter(fn($e) => Carbon::parse($e->date)->isCurrentWeek())->count();
        return view('responsable.emploi', compact(
            'emploisTemps',
            'classes',
            'formations',
            'filieres',
            'enseignantsCount',
            'conflitsCount',
            'coursSemaine'
        ));
    }


    private function detectConflicts($emplois)
    {
        $conflicts = 0;
        $grouped = $emplois->groupBy(function($item) {
            return $item->date . '|' . $item->heure_debut . '|' . $item->heure_fin;
        });

        foreach ($grouped as $group) {
            // Conflit de salle
            $salles = $group->pluck('salle')->unique();
            if ($salles->count() < $group->count()) {
                $conflicts += $group->count() - $salles->count();
            }

            // Conflit d'enseignant
            $enseignants = $group->pluck('enseignant_id')->unique();
            if ($enseignants->count() < $group->count()) {
                $conflicts += $group->count() - $enseignants->count();
            }
        }

        return $conflicts;
    }
//     public function classeStats($classeId)
// {
//     // Cours cette semaine
//     $coursSemaine = emplois_temps::where('classe_id', $classeId)
//         ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
//         ->count();

//     // Nombre d'enseignants distincts
//     $enseignantsCount = emplois_temps::where('classe_id', $classeId)
//         ->distinct('enseignant_id')
//         ->count('enseignant_id');

//     // Exemple simple pour les conflits (à adapter selon votre logique)
//     $conflitsCount = emplois_temps::where('classe_id', $classeId)
//         ->select('jour', 'heure_debut', 'heure_fin')
//         ->groupBy('jour', 'heure_debut', 'heure_fin')
//         ->havingRaw('COUNT(*) > 1')
//         ->get()
//         ->count();

//     return response()->json([
//         'coursSemaine' => $coursSemaine,
//         'enseignantsCount' => $enseignantsCount,
//         'conflitsCount' => $conflitsCount,
//     ]);
// }

    public function create()
    {
        return view('responsable.create_emploi', [
            'classes' => Classe::orderBy('nom_classe')->get(),
            'matieres' => Matiere::orderBy('nom_matiere')->get(),
            'enseignants' => Enseignant::orderBy('enseignant_nom')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'jour' => 'required|string',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'salle' => 'required|string|max:50',
        ]);

        // Vérification des conflits
        $conflict = emplois_temps::where('date', $validated['date'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
                      ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('heure_debut', '<=', $validated['heure_debut'])
                            ->where('heure_fin', '>=', $validated['heure_fin']);
                      });
            })
            ->where(function($query) use ($validated) {
                $query->where('salle', $validated['salle'])
                      ->orWhere('enseignant_id', $validated['enseignant_id']);
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->withErrors([
                'conflict' => 'Conflit détecté: la salle ou l\'enseignant est déjà occupé sur ce créneau'
            ]);
        }

        emplois_temps::create($validated);

        return redirect()->route('responsable.emploi', ['classe_id' => $validated['classe_id']])
            ->with('success', 'Cours ajouté avec succès');
    }

    public function edit($id)
{
    $emploiTemps = emplois_temps::findOrFail($id);
    $matieres = Matiere::all();
    $enseignants = Enseignant::all();
    return view('responsable.edit_emploi', compact('emploiTemps', 'matieres', 'enseignants'));
}

public function update(Request $request, $id)
{
    // dd($request->all());
    $timetable = emplois_temps::findOrFail($id);

    $validatedData = $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'jour' => 'required|string|max:255',
        'date' => 'required|date',
         'heure_debut' => 'required',
         'heure_fin' => 'required',
        'matiere_id' => 'required|exists:matieres,id',
        'enseignant_id' => 'required|exists:enseignants,id',
        'salle' => 'required|string|max:255',
    ]);
    $timetable->update( $validatedData);
// dd($timetable->save());
    return redirect()->route('responsable.emploi', ['classe_id' => $timetable->classe_id])
        ->with('success', 'Cours mis à jour avec succès.');
}


public function destroy(emplois_temps $timetable)
{
    $timetable->delete();
    return redirect()->route('responsable.emploi')->with('success', 'Cours supprimé avec succès.');
}
    public function emploiPdf($classeId)
    {
        $classe = Classe::findOrFail($classeId);
        $emploisTemps = emplois_temps::where('classe_id', $classeId)
            ->orderByRaw("FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi')")
            ->orderBy('heure_debut')
            ->get();

        $pdf = PDF::loadView('responsable.emploi_pdf', compact('classe', 'emploisTemps'));

        return $pdf->download('emploi-du-temps-' . Str::slug($classe->nom_classe) . '.pdf');
    }

    public function createComplet()
    {
       return view('responsable.create_emploi_complet', [
        'classes' => Classe::with('filiere.formation')->orderBy('nom_classe')->get(),
        'filieres' => Filiere::orderBy('nom_filiere')->get(),
        'formations' => Formation::orderBy('nom_formation')->get(),
        'matieres' => Matiere::orderBy('nom_matiere')->get(),
        'enseignants' => Enseignant::orderBy('enseignant_nom')->get(),
    ]);
    }



public function storeMultiple(Request $request)
{
    $validated = $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'cours' => 'required|array|min:1',
        'cours.*.jour' => 'required|string',
        'cours.*.date' => 'required|date',
        'cours.*.heure_debut' => 'required|date_format:H:i',
        'cours.*.heure_fin' => 'required|date_format:H:i|after:cours.*.heure_debut',
        'cours.*.matiere_id' => 'required|exists:matieres,id',
        'cours.*.enseignant_id' => 'required|exists:enseignants,id',
        'cours.*.salle' => 'required|string|max:50',
    ]);

    foreach ($validated['cours'] as $index => $cours) {
        // Vérification heure_debut < heure_fin (déjà validé mais sécurité)
        if (strtotime($cours['heure_fin']) <= strtotime($cours['heure_debut'])) {
            return back()->withErrors([
                "cours.$index.heure_fin" => "L'heure de fin doit être après l'heure de début pour le cours " . ($index + 1),
            ])->withInput();
        }

        // Vérification conflit enseignant
        $conflit = emplois_temps::where('enseignant_id', $cours['enseignant_id'])
            ->where('jour', $cours['jour'])
            ->where(function ($query) use ($cours) {
                $query->where(function ($q) use ($cours) {
                    $q->where('heure_debut', '<', $cours['heure_fin'])
                      ->where('heure_fin', '>', $cours['heure_debut']);
                });
            })
            ->exists();

        if ($conflit) {
            return back()->withErrors([
                "cours.$index.enseignant_id" => "Conflit détecté : l'enseignant a déjà un cours à ce créneau pour le cours " . ($index + 1),
            ])->withInput();
        }

        // Création du créneau
        emplois_temps::create([
            'classe_id' => $validated['classe_id'],
            'jour' => ucfirst(strtolower(trim($cours['jour']))),
            'date' => $cours['date'],
            'heure_debut' => $cours['heure_debut'],
            'heure_fin' => $cours['heure_fin'],
            'matiere_id' => $cours['matiere_id'],
            'enseignant_id' => $cours['enseignant_id'],
            'salle' => $cours['salle'],
        ]);
    }

    return redirect()->route('responsable.emploi', ['classe_id' => $validated['classe_id']])
        ->with('success', 'Emploi du temps généré avec succès.');
}

    private function generateTimeSlots()
    {
        $slots = [];
        $start = Carbon::createFromTime(8, 45); // Début à 8h45
        $end = Carbon::createFromTime(17, 30);  // Fin à 17h30

        while ($start < $end) {
            $next = $start->copy()->addMinutes(90); // Cours de 1h30

            if ($next > $end) break;

            $slots[] = $start->format('H:i') . ' - ' . $next->format('H:i');

            // Pause de 15 minutes (30 minutes après le matin)
            $start = $next->copy()->addMinutes($start->hour < 12 ? 15 : 30);
        }

        return $slots;
    }
    public function checkConflits(Request $request)
{
    $validated = $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'matiere_id' => 'required|exists:matieres,id',
        'enseignant_id' => 'required|exists:enseignants,id',
        'jour' => 'required|string',
        'date' => 'required|date',
        'heure_debut' => 'required|date_format:H:i',
        'heure_fin' => 'required|date_format:H:i|after:heure_debut',
        'salle' => 'required|string|max:50',
        'emploi_id' => 'nullable|exists:emploi_temps,id'
    ]);

    $query = emplois_temps::where('date', $validated['date'])
        ->where(function($q) use ($validated) {
            $q->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
              ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
              ->orWhere(function($q2) use ($validated) {
                  $q2->where('heure_debut', '<=', $validated['heure_debut'])
                     ->where('heure_fin', '>=', $validated['heure_fin']);
              });
        })
        ->where('id', '!=', $validated['emploi_id']);

    $conflits = [];

    // Vérification conflit salle
    $conflitSalle = $query->clone()->where('salle', $validated['salle'])->first();
    if ($conflitSalle) {
        $conflits[] = "La salle est déjà occupée par " . $conflitSalle->matiere->nom_matiere .
                      " (" . $conflitSalle->classe->nom_classe . ")";
    }

    // Vérification conflit enseignant
    $conflitEnseignant = $query->clone()->where('enseignant_id', $validated['enseignant_id'])->first();
    if ($conflitEnseignant) {
        $conflits[] = "L'enseignant a déjà cours pour " . $conflitEnseignant->matiere->nom_matiere .
                      " (" . $conflitEnseignant->classe->nom_classe . ")";
    }

    return response()->json([
        'conflit' => !empty($conflits),
        'message' => !empty($conflits) ? 'Ce créneau entre en conflit avec des cours existants:' : '',
        'details' => $conflits
    ]);
}
//etudiant
public function emploiEtudiant()
{
    $user = Auth::guard('etudiant')->user(); // Récupérer l'utilisateur connecté
    if (!$user) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
    }

    $classeId = $user->classes_id; // Assurez-vous que la colonne `classes_id` existe dans la table `etudiants`
    if (!$classeId) {
        return redirect()->back()->with('error', 'Aucune classe associée à votre compte.');
    }

    // Récupérer les emplois du temps pour la classe de l'étudiant
    $emploisTemps = emplois_temps::with(['matiere', 'enseignant', 'classe'])
        ->where('classe_id', $classeId)
        ->orderBy('jour')
        ->orderBy('heure_debut')
        ->get();


    return view('etudiant.emploi', [
        'emploisTemps' => $emploisTemps,
        'classeName' => $user->classe->nom_classe ?? 'Classe Non Spécifiée',

    ]);
}
public function downloadForEtudiant()
{
    $user = Auth::guard('etudiant')->user();

    if (!$user || !$user->classes_id) {
        return redirect()->back()->with('error', 'Aucune classe associée à votre compte.');
    }

    $classe = Classe::find($user->classes_id);
    $emploisTemps = emplois_temps::where('classe_id', $user->classes_id)->with(['matiere', 'enseignant'])->get();

    if ($emploisTemps->isEmpty()) {
        return redirect()->back()->with('error', 'Aucun emploi du temps disponible pour votre classe.');
    }

    // Utiliser le chemin correct pour la vue
    $pdf = PDF::loadView('responsable.emploi_pdf', compact('classe', 'emploisTemps'));

    $fileName = 'emploi_du_temps_' . str_replace(' ', '_', strtolower($classe->nom_classe)) . '.pdf';
    return $pdf->download($fileName);
}
 public function declarerAbsence(Request $request)
    {
        $request->validate([
            'emploi_id' => 'required|exists:emplois_temps,id',
            'statut' => 'required|in:annule,reporte',
            'motif_annulation' => 'required|string|max:500'
        ]);

        emplois_temps::where('id', $request->emploi_id)->update([
            'statut' => $request->statut,
            'motif_annulation' => $request->motif_annulation
        ]);

        return back()->with('success', 'Statut du cours mis à jour avec succès');
    }
}

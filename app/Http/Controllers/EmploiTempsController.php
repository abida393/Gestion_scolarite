<?php

namespace App\Http\Controllers;

use App\Models\emplois_temps;

use App\Models\Matiere;
 use App\Models\Enseignant;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Formation;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;



class EmploiTempsController extends Controller
{
    
    
    
    public function showEmplois(Request $request)
{
    $classes = Classe::all(); // Charger toutes les classes
    $classeId = $request->input('classe_id'); // Récupérer la classe sélectionnée

    // Récupérer tous les emplois du temps
    $emploisTemps = emplois_temps::with(['matiere', 'enseignant', 'classe'])->get();

    // Filtrer les emplois du temps par classe si une classe est sélectionnée
    $emploisClasse = collect(); // Initialiser une collection vide
    if ($classeId) {
        $emploisClasse = $emploisTemps->where('classe_id', $classeId);
    }

    return view('Emploi.emploi', compact('emploisTemps', 'emploisClasse', 'classes'));
}
    public function emploi()
    {
        $emploisTemps = emplois_temps::all();
        $classeName = 'fayssal'; // Remplacez par la logique pour récupérer le nom de la classe
        return view('Emploi.emploi', compact('emploisTemps', 'classeName'));
    }

    public function create()
    {
        $formations = Formation::all();
        $filieres = Filiere::all();
        $classes = Classe::all();
    
        return view('Emploi.create_emploi_complet', compact('formations', 'filieres', 'classes'));
        
    }

    
    public function getFilieresByFormation($formationId)
    {
        $filieres = Filiere::where('formation_id', $formationId)->get();
        return response()->json($filieres);
    }

    public function getClassesByFiliere($filiereId)
    {
        $classes = Classe::where('filieres_id', $filiereId)->get();
        return response()->json($classes);
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
        'formation_id' => 'required|exists:formations,id',
        'filiere_id' => 'required|exists:filieres,id',
    ]);
    dd($request->all());

    emplois_temps::create($validatedData);

    return redirect()->route('emploi')->with('success', 'Cours ajouté avec succès.');
}

public function edit_emploi(emplois_temps $timetable)
{
    $matieres = Matiere::all();
    $enseignants = Enseignant::all();
    $classes = Classe::all();
    $timeSlots = $this->generateTimeSlots(); // Générer les plages horaires

    return view('Emploi.edit_emploi', [
        'emploiTemp' => $timetable,
        'matieres' => $matieres,
        'enseignants' => $enseignants,
        'classes' => $classes,
        'timeSlots' => $timeSlots, // Transmettre les plages horaires
    ]);
}

    
    public function update(Request $request, emplois_temps $timetable)
    {
        $validatedData = $request->validate([
            'jour' => 'required|string|max:255',
            'date' => 'required|date',
            'horaire' => 'required|string',
            'matiere_id' => 'required|exists:matieres,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'salle' => 'required|string|max:255',
        ]);
    
        $horaire = explode(' - ', $validatedData['horaire']);
        $timetable->update([
            'jour' => $validatedData['jour'],
            'date' => $validatedData['date'],
            'heure_debut' => $horaire[0],
            'heure_fin' => $horaire[1],
            'matiere_id' => $validatedData['matiere_id'],
            'enseignant_id' => $validatedData['enseignant_id'],
            'salle' => $validatedData['salle'],
        ]);
    
        return redirect()->route('emploi')->with('success', 'Cours mis à jour avec succès.');
    }
    
public function destroy(emplois_temps $timetable)
{
    $timetable->delete();
    return redirect()->route('emploi')->with('success', 'Cours supprimé avec succès.');
}

    // 👉 Ajouter un emploi du temps complet (plusieurs cours)
    public function createComplet()
{
    $formations = Formation::all();
    $filiere = Filiere::all();
    $filieres = [];
    foreach ($filiere as $item) {
        $filieres[] = $item;
    }
    $matieres = Matiere::all();
    $enseignants = Enseignant::all();
    $classes = Classe::all();
    return view('Emploi.create_emploi_complet', compact('formations', 'filieres', 'matieres', 'enseignants', 'classes'));
}


public function edit($id)
{
    $emploiTemp = emplois_temps::findOrFail($id);
    $matieres = Matiere::all();
    $enseignants = Enseignant::all();
    $classes = Classe::all();
    $timeSlots = $this->generateTimeSlots(); // Générer les plages horaires

    return view('Emploi.edit_emploi', compact('emploiTemp', 'matieres', 'enseignants', 'classes', 'timeSlots'));
}


public function storeMultiple(Request $request)
{
    $data = $request->validate([
        'formation_id' => 'required|exists:formations,id',
        'filiere_id' => 'required|exists:filieres,id',
        'classe_id' => 'required|exists:classes,id',
        'cours.*.jour' => 'required|string|max:255',
        'cours.*.date' => 'required|date',
        'cours.*.horaire' => 'required|string',
        'cours.*.matiere_id' => 'required|exists:matieres,id',
        'cours.*.enseignant_id' => 'required|exists:enseignants,id',
        'cours.*.salle' => 'required|string|max:255',
    ]);

   

    try {
        foreach ($data['cours'] as $cours) {
            $horaire = explode(' - ', $cours['horaire']);
            emplois_temps::create([
                'formation_id' => $data['formation_id'],
                'filiere_id' => $data['filiere_id'],
                'classe_id' => $data['classe_id'],
                'jour' => $cours['jour'],
                'date' => $cours['date'],
                'heure_debut' => $horaire[0],
                'heure_fin' => $horaire[1],
                'matiere_id' => $cours['matiere_id'],
                'enseignant_id' => $cours['enseignant_id'],
                'salle' => $cours['salle'],
            ]);
        }

        \DB::commit();

        return redirect()->route('emploi')->with('success', 'Emploi du temps complet ajouté avec succès.');
    } catch (\Exception $e) {
        \DB::rollBack();
        return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de l\'emploi du temps.');
    }
}

private function generateTimeSlots()
{
    $startTime = new \DateTime('08:45'); // Début des cours à 8h45
    $endTime = new \DateTime('17:30'); // Fin des cours à 17h30
    $timeSlots = [];

    while ($startTime < $endTime) {
        $nextTime = clone $startTime;
        $nextTime->modify('+1 hour 30 minutes'); // Ajouter 1h30

        if ($nextTime > $endTime) {
            break;
        }

        $timeSlots[] = $startTime->format('H:i') . ' - ' . $nextTime->format('H:i');
        $startTime = clone $nextTime;

        // Ajouter une pause
        if ($startTime->format('H:i') === '12:15') {
            $startTime->modify('+30 minutes'); // Pause de 30 minutes après le matin
        } else {
            $startTime->modify('+15 minutes'); // Pause de 15 minutes
        }
    }

    return $timeSlots;
}
public function dashboard()
{
    $today = now()->locale('fr')->isoFormat('dddd');
     // Obtenir le jour actuel en français
    $emploisTemps = emplois_temps::whereDate('date', now()->toDateString())->with(['matiere', 'enseignant', 'classe'])->get();

    return view('Emploi.dashboard', compact('today', 'emploisTemps'));
}




public function emploiEtudiant()
{
    // Vérifier si l'utilisateur est connecté
    $user = Auth::guard('etudiant')->user();
    if (!$user) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
    }

    // Vérifier si l'utilisateur a une classe associée
    $classeId = $user->classes_id;
    
    if (!$classeId) {
        return redirect()->back()->with('error', 'Aucune classe associée à cet utilisateur.');
    }

    // Récupérer les cours de la classe
    $emploisTemps = emplois_temps::with(['matiere', 'enseignant', 'classe'])
        ->where('classe_id', $classeId)
        ->orderBy('jour')
        ->orderBy('heure_debut')
        ->get();

    // Récupérer le nom de la classe
    $classeName = Classe::find($classeId)->nom_classe ?? 'Classe Non Spécifiée';

    return view('Emploi.emploi_etudiant', compact('emploisTemps', 'classeName'));
}
//use Pdf; // Assurez-vous d'avoir installé dompdf ou un package similaire

public function download(Request $request)
{
    // Récupérer l'ID de la classe depuis la requête
    $classeId = $request->query('classe_id');

    // Vérifier si la classe existe
    $classe = Classe::find($classeId);
    if (!$classe) {
        return redirect()->route('emploi')->with('error', 'Classe introuvable.');
    }

    // Récupérer les emplois du temps pour la classe
    $emploisTemps = emplois_temps::where('classe_id', $classeId)->with(['matiere', 'enseignant'])->get();

    // Vérifier si des emplois du temps existent pour cette classe
    if ($emploisTemps->isEmpty()) {
        return redirect()->route('emploi')->with('error', 'Aucun emploi du temps trouvé pour cette classe.');
    }

    // Générer le PDF en utilisant la vue 'Emploi.emploi_pdf'
    $pdf = \PDF::loadView('Emploi.emploi_pdf', compact('classe', 'emploisTemps'));

    // Télécharger le fichier PDF avec un nom de fichier clair
    $fileName = 'emploi_du_temps_' . str_replace(' ', '_', strtolower($classe->nom_classe)) . '.pdf';
    return $pdf->download($fileName);
}
public function downloadForEtudiant()
{
    // Récupérer l'utilisateur connecté
    $user = Auth::guard('etudiant')->user();

    // Vérifier si l'utilisateur a une classe associée
    if (!$user || !$user->classes_id) {
        return redirect()->back()->with('error', 'Aucune classe associée à votre compte.');
    }

    // Récupérer la classe et les emplois du temps
    $classe = Classe::find($user->classes_id);
    $emploisTemps = emplois_temps::where('classe_id', $user->classes_id)->with(['matiere', 'enseignant'])->get();

    // Vérifier si des emplois du temps existent
    if ($emploisTemps->isEmpty()) {
        return redirect()->back()->with('error', 'Aucun emploi du temps disponible pour votre classe.');
    }

    // Générer le PDF en utilisant la vue 'emploi_pdf'
    $pdf = PDF::loadView('Emploi.emploi_pdf', compact('classe', 'emploisTemps'));

    // Télécharger le fichier PDF avec un nom de fichier clair
    $fileName = 'emploi_du_temps_' . str_replace(' ', '_', strtolower($classe->nom_classe)) . '.pdf';
    return $pdf->download($fileName);
}
// public function dashboard()
// {
//     $today = Carbon::now()->locale('fr')->isoFormat('dddd'); // Récupère le jour actuel en français
//     $emploisTemps = emplois_temps::with(['matiere', 'enseignant', 'classe'])
//         ->whereDate('date', Carbon::today()) // Filtre les cours du jour
//         ->get();

//     return view('pages.Home', compact('emploisTemps', 'today'));
// }
}

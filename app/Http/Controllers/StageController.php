<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    //

public function index()
{
    $stages = Stage::all();
    return view("etudiant.stages", compact('stages')); // pas 'stages.index'
}


 // Méthode pour créer une nouvelle offre de stage
 public function createStage(Request $request)
 {
     // Validation des données de création de stage
     $request->validate([
         'nom_stage' => 'required|string|max:255',
         'entreprise' => 'required|string|max:255',
         'domaine' => 'required|string',
         'duree' => 'required|string',
         'email_entreprise' => 'required|email',
         'photo' => 'nullable|url',
         'description' => 'required|string',
     ]);

     // Création de la nouvelle offre de stage dans la base de données
     $stage = Stage::create([
         'nom_stage' => $request->nom_stage,
         'entreprise' => $request->entreprise,
         'domaine' => $request->domaine,
         'duree' => $request->duree,
         'email_entreprise' => $request->email_entreprise,
         'photo' => $request->photo,
         'description' => $request->description,
     ]);

     // Rediriger après la création
     return redirect()->route('stages.index')->with('success', 'Offre de stage créée avec succès');
 }


 public function indexEtudiant()
{
    $stages = Stage::all();
    return view('etudiant.stage', compact('stages')); // Exemple : resources/views/etudiant/stage.blade.php
}

public function indexResponsable(Request $request)
{
    $stages = Stage::all();
    $stageToEdit = null;

    if ($request->has('edit')) {
        $stageToEdit = Stage::find($request->input('edit'));
    }

    return view('responsable.stage', compact('stages', 'stageToEdit'));
}


public function store(Request $request)
{
    // Validation
    $request->validate([
        'nom_stage' => 'required',
        'entreprise' => 'required',
        'domaine' => 'required',
        'duree' => 'required',
        'email_entreprise' => 'required|email',
        'description' => 'required',
        'photo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Photo obligatoire
    ]);

    // Créer un nouvel objet Stage
    $stage = new Stage();
    $stage->nom_stage = $request->nom_stage;
    $stage->entreprise = $request->entreprise;
    $stage->domaine = $request->domaine;
    $stage->duree = $request->duree;
    $stage->email_entreprise = $request->email_entreprise;
    $stage->description = $request->description;

    // Vérifier si une photo a été téléchargée
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoPath = $photo->store('photos', 'public');  // Sauvegarder l'image dans le dossier public/photos
        $stage->photo = $photoPath;  // Sauvegarder le chemin de l'image dans la base de données
    }

    // Sauvegarder le stage
    $stage->save();

    return redirect()->route('stages-responsable')->with('success', 'Stage ajouté avec succès');
}


public function edit($id)
{
    $stage = Stage::findOrFail($id);
    return view('stages.edit', compact('stage'));
}

// Mettre à jour le stage
public function update(Request $request, $id)
{
    $stage = Stage::findOrFail($id);

    $request->validate([
        'nom_stage' => 'required',
        'entreprise' => 'required',
        'domaine' => 'required',
        'duree' => 'required',
        'email_entreprise' => 'required|email',
        'description' => 'required',
    ]);

    $data = $request->all();

    // Si une nouvelle photo est téléchargée
    if ($request->hasFile('photo')) {
        $photoName = time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads/stages'), $photoName);
        $data['photo'] = $photoName;
    } else {
        // Si aucune photo n'est envoyée, garder l'ancienne
        unset($data['photo']);
    }

    $stage->update($data);

    return redirect()->route('stages-responsable')->with('success', 'Stage modifié avec succès');
}

 // Supprimer un stage
 public function destroy($id)
 {
     $stage = Stage::findOrFail($id);
     $stage->delete();

     return redirect()->route('stages-responsable')->with('success', 'Stage supprimé avec succès');
 }
 
}
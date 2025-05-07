<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    //
public function index()
{
    $stages = Stage::all();
    return view('stages.index', compact('stages'));
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
}
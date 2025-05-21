<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    // Méthode pour afficher tous les étudiants
    public function index()
    {
        // Récupérer tous les étudiants depuis la base de données
        $etudiants = Etudiant::all();
        
        // Passer les étudiants à la vue 'etudiants.index'
        return view('etudiants.index', compact('etudiants'));
    }

    // Autres méthodes comme 'create', 'store', etc.
}

<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\etudiant;
use App\Models\Filiere;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ajouterEtudiantController extends Controller
{
    function index()
    {
        $formations = Formation::all();
        $classes = Classe::all();
        $filieres = Filiere::all();
        return view('responsable.ajouter-etudiant', compact('formations', 'classes', 'filieres'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            // Personal Information
            'etudiant_nom' => 'required|string|max:255',
            'etudiant_prenom' => 'required|string|max:255',
            'etudiant_cin' => 'required|string|max:255|unique:etudiants,etudiant_cin',
            'etudiant_date_naissance' => 'required|date',
            'etudiant_lieu_naissance' => 'required|string|max:255',
            'etudiant_sexe' => 'required|in:Male,Female',
            'etudiant_nationalite' => 'required|string|max:255',
            'PHOTOS' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Contact Information
            'etudiant_adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'etudiant_code_postal' => 'nullable|string|max:20',
            'etudiant_tel' => 'required|string|max:20',
            'etudiant_email' => 'nullable|email|max:255',
            'email_ecole' => 'required|email|max:255|unique:etudiants,email_ecole',

            // Academic Information
            'formation_id' => 'required|exists:formations,id',
            'classes_id' => 'required|exists:classes,id',
            'filiere_id' => 'required|exists:filieres,id',
            'identifiant' => 'required|string|max:255|unique:etudiants,identifiant',
            'password' => 'required|string|min:8',
            'etudiant_cne' => 'required|string|max:255|unique:etudiants,etudiant_cne',
            'DOSSIERCOMPLET' => 'nullable|boolean',

            // Baccalaureate Information
            'etudiant_serie_bac' => 'required|string|max:255',
            'etudiant_session_bac' => 'required|string|max:255',
            'etudiant_mention_bac' => 'required|string|max:255',
            'annee_obtention_bac' => 'required|date',

            // Father's Information
            'nom_pere' => 'required|string|max:255',
            'prenom_pere' => 'required|string|max:255',
            'fonction_pere' => 'nullable|string|max:255',
            'telephone_pere' => 'required|string|max:20',
            'cnss' => 'nullable|string|max:255',

            // Mother's Information
            'nom_mere' => 'required|string|max:255',
            'prenom_mere' => 'required|string|max:255',
            'fonction_mere' => 'nullable|string|max:255',
            'telephone_mere' => 'required|string|max:20',
        ]);

        try {
        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('PHOTOS')) {
            $photoPath = $request->file('PHOTOS')->store('etudiants/photos', 'public');
        }

        // Create the student record
        $etudiant = etudiant::create([
            // Personal Information
            'type_profile' => 'etudiant', // Assuming this is fixed for students
            'etudiant_nom' => $validatedData['etudiant_nom'],
            'etudiant_prenom' => $validatedData['etudiant_prenom'],
            'etudiant_cin' => $validatedData['etudiant_cin'],
            'etudiant_date_naissance' => $validatedData['etudiant_date_naissance'],
            'etudiant_lieu_naissance' => $validatedData['etudiant_lieu_naissance'],
            'etudiant_sexe' => $validatedData['etudiant_sexe'],
            'etudiant_nationalite' => $validatedData['etudiant_nationalite'],
            'PHOTOS' => $photoPath,

            // Contact Information
            'etudiant_adresse' => $validatedData['etudiant_adresse'],
            'ville' => $validatedData['ville'],
            'etudiant_code_postal' => $validatedData['etudiant_code_postal'],
            'etudiant_tel' => $validatedData['etudiant_tel'],
            'etudiant_email' => $validatedData['etudiant_email'],
            'email_ecole' => $validatedData['email_ecole'],

            // Academic Information
            'formation_id' => $validatedData['formation_id'],
            'classes_id' => $validatedData['classes_id'],
            'filiere_id' => $validatedData['filiere_id'],
            'identifiant' => $validatedData['identifiant'],
            'password' => Hash::make($validatedData['password']),
            'etudiant_cne' => $validatedData['etudiant_cne'],
            'DOSSIERCOMPLET' => $validatedData['DOSSIERCOMPLET'] ?? false,

            // Baccalaureate Information
            'etudiant_serie_bac' => $validatedData['etudiant_serie_bac'],
            'etudiant_session_bac' => $validatedData['etudiant_session_bac'],
            'etudiant_mention_bac' => $validatedData['etudiant_mention_bac'],
            'annee_obtention_bac' => $validatedData['annee_obtention_bac'],

            // Parent Information
            'nom_pere' => $validatedData['nom_pere'],
            'prenom_pere' => $validatedData['prenom_pere'],
            'fonction_pere' => $validatedData['fonction_pere'],
            'telephone_pere' => $validatedData['telephone_pere'],
            'cnss' => $validatedData['cnss'],
            'nom_mere' => $validatedData['nom_mere'],
            'prenom_mere' => $validatedData['prenom_mere'],
            'fonction_mere' => $validatedData['fonction_mere'],
            'telephone_mere' => $validatedData['telephone_mere'],
        ]);

        return redirect()->route('ajouter-etudiant')
            ->with('success', 'Student created successfully!');
        } catch (\Exception $e) {
            // Delete the uploaded photo if student creation fails
            if (isset($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            return back()->withInput()
                ->with('error', 'Error creating student: ' . $e->getMessage());
        }
    }
}

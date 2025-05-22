<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\etudiant;
use App\Models\enseignant;
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

    function afficherEtudiants(Request $request){
        $query = Etudiant::with(['classe', 'formation'])
            ->orderBy('etudiant_nom')
            ->orderBy('etudiant_prenom');

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('etudiant_nom', 'like', "%$search%")
                  ->orWhere('etudiant_prenom', 'like', "%$search%")
                  ->orWhere('etudiant_cne', 'like', "%$search%")
                  ->orWhere('etudiant_email', 'like', "%$search%");
            });
        }

        // Apply class filter if provided
        if ($request->has('class_filter') && $request->input('class_filter') != '') {
            $query->where('classes_id', $request->input('class_filter'));
        }

        // Apply formation filter if provided
        if ($request->has('formation_filter') && $request->input('formation_filter') != '') {
            $query->where('formation_id', $request->input('formation_filter'));
        }

        $etudiants = $query->paginate(15);
        $classes = Classe::orderBy('nom_classe')->get();
        $formations = Formation::orderBy('nom_formation')->get();
        return view('responsable.afficher-etudiants', compact('etudiants', 'classes', 'formations'));
    }
    public function edit(Etudiant $etudiant)
    {
        $classes = Classe::orderBy('nom_classe')->get();
        $formations = Formation::orderBy('nom_formation')->get();
        return view('responsable.edit_etudiants', compact('etudiant', 'classes', 'formations'));
    }

    public function update(Request $request, Etudiant $etudiant)
{

    // Validate the request data
    $validatedData = $request->validate([
        // Personal Information
        'etudiant_nom' => 'required|string|max:255',
        'etudiant_prenom' => 'required|string|max:255',
        'etudiant_cin' => 'required|string|max:255',
        'etudiant_cne' => 'required|string|max:255',
        'etudiant_date_naissance' => 'required|date',
        'etudiant_sexe' => 'required|string|in:Masculin,Féminin',
        'PHOTOS' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        // Academic Information
        'formation_id' => 'required|exists:formations,id',
        'classes_id' => 'required|exists:classes,id',
        'etudiant_serie_bac' => 'required|string|max:255',
        'etudiant_session_bac' => 'required|string|max:255',
        'etudiant_mention_bac' => 'required|string|max:255',
        'annee_obtention_bac' => 'required|date',

        // Contact Information
        'etudiant_email' => 'required|email|max:255',
        'etudiant_tel' => 'required|string|max:255',
        'etudiant_adresse' => 'required|string|max:255',
        'ville' => 'required|string|max:255',

        // Parent Information
        'nom_pere' => 'required|string|max:255',
        'telephone_pere' => 'required|string|max:255',
        'nom_mere' => 'required|string|max:255',
        'telephone_mere' => 'required|string|max:255',
    ]);

    // Handle file upload
    if ($request->hasFile('PHOTOS')) {
        // Delete old photo if exists
        if ($etudiant->PHOTOS && Storage::exists($etudiant->PHOTOS)) {
            Storage::delete($etudiant->PHOTOS);
        }

        // Store new photo
        $path = $request->file('PHOTOS')->store('etudiants/photos', 'public');
        $validatedData['PHOTOS'] = $path;
    } else {
        // Keep existing photo if no new one uploaded
        $validatedData['PHOTOS'] = $etudiant->PHOTOS;
    }

    // Update password only if provided
    // if ($request->filled('password')) {
    //     $validatedData['password'] = Hash::make($request->password);
    // } else {
    //     unset($validatedData['password']);
    // }

    // Update the student record
    $etudiant->update($validatedData);
    return redirect()->route('responsable.afficher_etudiant')
        ->with('success', 'Les informations de l\'étudiant ont été mises à jour avec succès');
}

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès');
    }

    public function afficherEnseignants(Request $request){
        $query = Enseignant::query()
        ->orderBy('enseignant_nom')
        ->orderBy('enseignant_prenom');

    // Search filter
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('enseignant_nom', 'like', "%$search%")
              ->orWhere('enseignant_prenom', 'like', "%$search%")
              ->orWhere('enseignant_specialite', 'like', "%$search%")
              ->orWhere('enseignant_email', 'like', "%$search%");
        });
    }

    // Status filter
    if ($request->has('status') && $request->input('status') != '') {
        $query->where('enseignant_permanent_vacataire', $request->input('status'));
    }

    // Contract type filter
    if ($request->has('contract') && $request->input('contract') != '') {
        $query->where('enseignant_contrat', $request->input('contract'));
    }

    $enseignants = $query->paginate(15);
        return view('responsable.afficher-enseignant', compact('enseignants'));
    }


    public function editEnseignant(Enseignant $enseignant)
    {
        return view('responsable.edit-enseignant', compact('enseignant'));
    }

    public function updateEnseignant(Request $request, Enseignant $enseignant){
         // Validate the request data with custom messages
    $validatedData = $request->validate([
        // Personal Information
        'enseignant_nom' => 'required|string|max:255',
        'enseignant_prenom' => 'required|string|max:255',
        'enseignant_sexe' => 'required|string|in:Masculin,Féminin',
        'enseignant_nationalite' => 'required|string|max:255',
        'enseignant_cin' => 'required|string|max:20|unique:enseignants,enseignant_cin,'.$enseignant->id,
        'enseignant_cnss' => 'nullable|string|max:50',
        'enseignant_date_naissance' => 'required|date|before_or_equal:today',
        'enseignant_lieu_naissance' => 'required|string|max:255',

        // Professional Information
        'enseignant_diplomes' => 'required|string|max:255',
        'enseignant_specialite' => 'required|string|max:255',
        'enseignant_contrat' => 'required|string|in:CDI,CDD',
        'enseignant_date_embauche' => 'required|date|after_or_equal:enseignant_date_naissance',
        'enseignant_salaire' => 'required|numeric|min:0',
        'enseignant_permanent_vacataire' => 'required|string|in:Permanent,Vacataire',
        'enseignant_fonction_principale' => 'required|string|max:255',
        'enseignant_employeur_principal' => 'required|string|max:255',

        // Contact Information
        'enseignant_tel' => 'required|string|max:20',
        'enseignant_adresse_postale' => 'required|string|max:500',
        'enseignant_email' => 'required|email|max:255|unique:enseignants,enseignant_email,'.$enseignant->id,

        // Banking Information
        'enseignant_type_paiement' => 'required|string|in:Virement,Chèque,Espèces',
        'enseignant_banque' => 'nullable|string|max:255',
        'enseignant_rib' => 'nullable|string|max:50',

    ], [
        'required' => 'Le champ :attribute est obligatoire.',
        'email' => 'L\'email doit être une adresse valide.',
        'unique' => 'Cette valeur est déjà utilisée pour un autre enseignant.',
        'date' => 'La date n\'est pas valide.',
        'before_or_equal' => 'La date de naissance doit être antérieure ou égale à aujourd\'hui.',
        'after_or_equal' => 'La date d\'embauche doit être postérieure ou égale à la date de naissance.',
        'numeric' => 'Le salaire doit être un nombre valide.',
        'min' => 'Le salaire ne peut pas être négatif.',
        'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
    ], [
        'enseignant_nom' => 'nom',
        'enseignant_prenom' => 'prénom',
        'enseignant_sexe' => 'sexe',
        'enseignant_nationalite' => 'nationalité',
        'enseignant_cin' => 'CIN',
        'enseignant_cnss' => 'CNSS',
        'enseignant_date_naissance' => 'date de naissance',
        'enseignant_lieu_naissance' => 'lieu de naissance',
        'enseignant_diplomes' => 'diplômes',
        'enseignant_specialite' => 'spécialité',
        'enseignant_contrat' => 'type de contrat',
        'enseignant_date_embauche' => 'date d\'embauche',
        'enseignant_salaire' => 'salaire',
        'enseignant_permanent_vacataire' => 'statut',
        'enseignant_fonction_principale' => 'fonction principale',
        'enseignant_employeur_principal' => 'employeur principal',
        'enseignant_tel' => 'téléphone',
        'enseignant_adresse_postale' => 'adresse postale',
        'enseignant_email' => 'email',
        'enseignant_type_paiement' => 'mode de paiement',
        'enseignant_banque' => 'banque',
        'enseignant_rib' => 'RIB',
    ]);

    try {
        // Format salary to 2 decimal places
        $validatedData['enseignant_salaire'] = number_format($validatedData['enseignant_salaire'], 2, '.', '');

        // Format dates to Y-m-d
        $validatedData['enseignant_date_naissance'] =$validatedData['enseignant_date_naissance'];
        $validatedData['enseignant_date_embauche'] = $validatedData['enseignant_date_embauche'];

        // Remove country code from phone if present
        if (strpos($validatedData['enseignant_tel'], '+212') === 0) {
            $validatedData['enseignant_tel'] = substr($validatedData['enseignant_tel'], 4);
        }

        // Update the teacher record
        $enseignant->update($validatedData);


        return redirect()
            ->route('responsable.afficher_enseignant')
            ->with('success', 'Les informations de l\'enseignant ont été mises à jour avec succès!');

    } catch (\Exception $e) {
        // Log the error
        Log::error('Erreur lors de la mise à jour de l\'enseignant: ' . $e->getMessage());

        return back()
            ->withInput()
            ->with('error', 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer.');
    }
    }


    public function displayAllEnseignant(Enseignant $enseignant)
    {
        return view('responsable.all-enseignant', compact('enseignant'));

    }
}

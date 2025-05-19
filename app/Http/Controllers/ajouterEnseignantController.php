<?php

namespace App\Http\Controllers;

use App\Models\enseignant;
use Illuminate\Http\Request;

class ajouterEnseignantController extends Controller
{
    public function index()
    {
        return view('responsable.ajouter-enseignant');
    }
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            // Informations personnelles
            'enseignant_nom' => 'required|string|max:255',
            'enseignant_prenom' => 'required|string|max:255',
            'enseignant_sexe' => 'required|in:Masculin,Féminin',
            'enseignant_nationalite' => 'required|string|max:255',
            'enseignant_cin' => 'required|string|max:255|unique:enseignants,enseignant_cin',
            'enseignant_cnss' => 'nullable|string|max:255',
            'enseignant_diplomes' => 'required|string',
            'enseignant_specialite' => 'required|string|max:255',
            'enseignant_date_naissance' => 'required|date',
            'enseignant_lieu_naissance' => 'required|string|max:255',

            // Informations de contact
            'enseignant_tel' => 'required|string|max:20',
            'enseignant_adresse_postale' => 'required|string|max:255',
            'enseignant_email' => 'required|email|max:255|unique:enseignants,enseignant_email',

            // Informations professionnelles
            'enseignant_contrat' => 'required|in:CDI,CDD',
            'enseignant_date_embauche' => 'required|date',
            'enseignant_salaire' => 'required|string|max:255',
            'enseignant_permanent_vacataire' => 'required|in:Permanent,Vacataire',
            'enseignant_fonction_principale' => 'required|string|max:255',
            'enseignant_employeur_principal' => 'nullable|string|max:255',

            // Informations bancaires
            'enseignant_type_paiement' => 'nullable|string|max:255',
            'enseignant_banque' => 'nullable|string|max:255',
            'enseignant_rib' => 'nullable|string|max:255',
        ]);
         try {
            // Création de l'enseignant
            Enseignant::create([
                // Informations personnelles
                'enseignant_nom' => $validatedData['enseignant_nom'],
                'enseignant_prenom' => $validatedData['enseignant_prenom'],
                'enseignant_sexe' => $validatedData['enseignant_sexe'],
                'enseignant_nationalite' => $validatedData['enseignant_nationalite'],
                'enseignant_cin' => $validatedData['enseignant_cin'],
                'enseignant_cnss' => $validatedData['enseignant_cnss'],
                'enseignant_diplomes' => $validatedData['enseignant_diplomes'],
                'enseignant_specialite' => $validatedData['enseignant_specialite'],
                'enseignant_date_naissance' => $validatedData['enseignant_date_naissance'],
                'enseignant_lieu_naissance' => $validatedData['enseignant_lieu_naissance'],

                // Informations de contact
                'enseignant_tel' => $validatedData['enseignant_tel'],
                'enseignant_adresse_postale' => $validatedData['enseignant_adresse_postale'],
                'enseignant_email' => $validatedData['enseignant_email'],

                // Informations professionnelles
                'enseignant_contrat' => $validatedData['enseignant_contrat'],
                'enseignant_date_embauche' => $validatedData['enseignant_date_embauche'],
                'enseignant_salaire' => $validatedData['enseignant_salaire'],
                'enseignant_permanent_vacataire' => $validatedData['enseignant_permanent_vacataire'],
                'enseignant_fonction_principale' => $validatedData['enseignant_fonction_principale'],
                'enseignant_employeur_principal' => $validatedData['enseignant_employeur_principal'],

                // Informations bancaires
                'enseignant_type_paiement' => $validatedData['enseignant_type_paiement'],
                'enseignant_banque' => $validatedData['enseignant_banque'],
                'enseignant_rib' => $validatedData['enseignant_rib'],
            ]);
            // Redirection avec message de succès
            return redirect()->route('admin.enseignants.index')
                ->with('success', 'Enseignant créé avec succès!');
        } catch (\Exception $e) {
            // En cas d'erreur, redirection avec message d'erreur
            return back()->withInput()
                ->with('error', 'Erreur lors de la création de l\'enseignant: ' . $e->getMessage());
        }
    }
}

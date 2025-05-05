<?php
namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DemandeDocument;
use Illuminate\Http\Request;

class DemandeDocumentController extends Controller
{
    // Affiche le formulaire
    public function create()
    {
        $documents = Document::all(); // Récupère tous les documents
        return view('demande.create', compact('documents')); 
         $documents = Document::all(); // Récupère tous les documents
        return view('nom_de_votre_vue', compact('documents')); // Passe les documents à la vue

    }

    // Traite la soumission
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'annee_academique' => 'required|string',
            'confirmation' => 'accepted' // Vérifie que la checkbox est cochée
        ]);

        // Crée la demande (avec l'ID de l'étudiant connecté)
        DemandeDocument::create([
            'id_etudiant' => auth()->id(), // Adaptez si votre auth est différente
            'id_document' => $request->document_id,
            'annee_academique' => $request->annee_academique,
            'etat_demande' => 'en attente'
        ]);

        return redirect()->route('demande.success')
                         ->with('success', 'Demande envoyée avec succès !');
    }

      
}
<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Paiement;
use Illuminate\Http\Request;


class PaiementController extends Controller
{
    public function index(){

    }
    public function search(Request $request)
{
    $etudiants = Etudiant::all();

    // Vérifie si une recherche est présente
    if ($request->filled('search')) {
        $search = $request->search;

        // Récupère l'historique complet des paiements de l'étudiant recherché
        $paiements = Paiement::with('etudiant')
            ->whereHas('etudiant', function ($q) use ($search) {
                $q->where('etudiant_nom', 'like', "%$search%")
                  ->orWhere('etudiant_prenom', 'like', "%$search%");
            })
            ->orderBy('date_paiement', 'desc')
            ->get();
    } else {
        // Aucun champ de recherche → affiche uniquement les derniers paiements (par exemple 10)
        $paiements = Paiement::with('etudiant')
            ->orderBy('date_paiement', 'desc')
            ->take(10)
            ->get();
    }

    return view('responsable.paiement-admin', compact('etudiants', 'paiements'));
}


    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'montant_total' => 'required|numeric|min:0',
            'montant_paye' => 'required|numeric|min:0',
            'montant_restant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|in:cash,virement,cheque',
            'date_paiement' => 'required|date',
        ]);

        if ($request->mode_paiement === 'cheque') {
            $request->validate([
                'numero_cheque' => 'required|string',
            ]);
        }

        $status = $request->mode_paiement === 'cheque' ? 'en attente' : 'confirmé';

        Paiement::create([
            'etudiant_id' => $request->etudiant_id,
            'montant_total' => $request->montant_total,
            'montant_paye' => $request->montant_paye,
            'montant_restant' => $request->montant_restant,
            'mode_paiement' => $request->mode_paiement,
            'numero_cheque' => $request->numero_cheque,
            'date_paiement' => $request->date_paiement,
            'status' => $status,
        ]);

        return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
    }
    public function changerStatut(Request $request, Paiement $paiement)
{
    $request->validate([
        'status' => 'required|in:confirmé,refusé'
    ]);

    $paiement->status = $request->status;
    $paiement->save();

    return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
}

}

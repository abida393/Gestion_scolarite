<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Models\DemandesDocuments;
use Illuminate\Contracts\Auth\Authenticatable;

class DocumentController extends Controller
{
    // Affiche le formulaire
    public function index()
{
    $documents = Document::all();
    return view('documents.index', compact('documents'));
}

public function store(Request $request)
{
    $request->validate([
        'id_document' => 'required|exists:documents,id',
        'annee_academique' => 'required|string',
    ]);

    $etudiant = Auth::guard('etudiant')->user();

    DemandesDocuments::create([
        'id_etudiant' => $etudiant->id,
        'id_document' => $request->id_document,
        'annee_academique' => $request->annee_academique,
    ]);
    
    return redirect()->back()->with('success', 'Demande envoyée avec succès.');
}
public function mesDemandes()
{
    $etudiant = Auth::guard('etudiant')->user();
   
    // Récupérer toutes les demandes de l'étudiant
    $demandes = DemandesDocuments::where('id_etudiant', $etudiant->id)
        ->with('document') // Si tu veux charger aussi les documents associés
        ->orderBy('created_at', 'desc') // Trier par date pour avoir les plus récentes en premier
        ->get();
   
    return view('etudiant.mes_demandes', compact('demandes'));
}


public function documents()
{
    $etudiant = Auth::guard('etudiant')->user();

    $documents = Document::all();

    $demandes = DemandesDocuments::where('id_etudiant', $etudiant->id)
        ->with('document')
        ->latest()
        ->get();
    
    return view('etudiant.documents', compact('documents', 'demandes'));
}

// Dans DocumentController.php
public function download($id)
{
    // Trouver la demande de document en fonction de l'ID
    $document = DemandesDocuments::findOrFail($id);
    
    // Vérifie que le statut du document est "termine" et qu'il existe un fichier associé
    if ($document->statut !== 'termine' || !$document->fichier) {
        return abort(404, 'Document non disponible');
    }

    // Définir le chemin du fichier (en supposant qu'il soit stocké dans storage/app/public/documents/)
    $filePath = storage_path('app/public/documents/' . $document->fichier);

    // Vérifie si le fichier existe réellement
    if (!file_exists($filePath)) {
        return abort(404, 'Fichier introuvable');
    }

    // Retourner le fichier pour téléchargement
    return response()->download($filePath);
}

}


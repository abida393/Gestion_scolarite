<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Models\DemandesDocuments;
use App\Models\Filiere;
use App\Models\Formation;
use App\Models\Classe;
use Illuminate\Support\Facades\Response;
use App\Notifications\DocumentPretNotification;


class DocumentController extends Controller
{
    // Affiche le formulaire
    public function index()
    {
        $documents = Document::all();
        $classes = Classe::all(); // Ajout de la récupération des classes
        return view('documents.index', compact('documents', 'classes'));
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
       
        $demandes = DemandesDocuments::where('id_etudiant', $etudiant->id)
            ->with('document')
            ->orderBy('created_at', 'desc')
            ->get();
       
        return view('etudiant.mes_demandes', compact('demandes'));
    }

    public function documents()
    {
        $etudiant = Auth::guard('etudiant')->user();
        $documents = Document::all();
        $classes = Classe::all(); // Ajout des classes

        $demandes = DemandesDocuments::where('id_etudiant', $etudiant->id)
            ->with('document')
            ->latest()
            ->get();
        
        return view('etudiant.documents', compact('documents', 'demandes', 'classes'));
    }

    public function download($id)
    {
        $document = DemandesDocuments::findOrFail($id);
        
        if ($document->etat_demande !== 'termine' || !$document->fichier) {
            return abort(404, 'Document non disponible');
        }

        $filePath = storage_path('app/public/documents/' . $document->fichier);

        if (!file_exists($filePath)) {
            return abort(404, 'Fichier introuvable');
        }

        return response()->download($filePath);
    }

    public function downloadFile($filename)
    {
        $filePath = storage_path('app/public/documents/' . $filename);
        
        if (file_exists($filePath)) {
            return Response::download($filePath, $filename);
        }

        abort(404);
    }

    public function indexResponsable()
    {
        $demandes = DemandesDocuments::with(['etudiant.filiere', 'etudiant.formation', 'etudiant.classe', 'document'])
            ->get();
        
        $filieres = Filiere::all();
        $classes = Classe::all(); // Ajout des classes
        
        return view('responsable.document', compact('demandes', 'filieres', 'classes'));
    }

    public function modifier($id)
    {
        $demande = DemandesDocuments::with(['etudiant', 'document'])->findOrFail($id);
        $classes = Classe::all(); // Ajout des classes
        
        return view('responsable.modifier_demande', compact('demande', 'classes'));
    }

    public function updateEtat(Request $request, $id)
{
    $demande = DemandesDocuments::findOrFail($id);

    $rules = [
        'etat_demande' => 'required|in:demande-recue,en-preparation,document-pret,termine,refus',
    ];

    if ($request->etat_demande === 'termine') {
        $rules['document'] = 'required|file|mimes:pdf,docx,jpeg,png|max:10240';
    }

    if ($request->etat_demande === 'refus') {
        $rules['justif_refus'] = 'required|string|max:1000'; // validation de la justification
    }

    $request->validate($rules);

    $demande->etat_demande = $request->etat_demande;

    // Enregistrement du fichier si terminé
    if ($request->hasFile('document')) {
        $path = $request->file('document')->store('documents', 'public');
        $demande->fichier = basename($path);
    }

    // Enregistrement de la justification si refus
    if ($request->etat_demande === 'refus') {
        $demande->justif_refus = $request->justif_refus;
    } else {
        $demande->justif_refus = null; // Optionnel : vider si autre état
    }

    $demande->save();

    return redirect()->route('responsable.documents.index')->with('success', 'État de la demande mis à jour.');
}

    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'document' => 'required|mimes:pdf,docx,jpeg,png|max:10240',
        ]);

        $demande = DemandesDocuments::findOrFail($id);

        if ($demande->etat_demande != 'termine') {
            return back()->with('error', 'Le statut de la demande doit être "Terminé" pour ajouter un fichier.');
        }

        $filePath = $request->file('document')->store('documents', 'public');
        $demande->fichier = basename($filePath);
        $demande->save();

        return back()->with('success', 'Fichier ajouté avec succès.');
    }

    public function destroy($id)
    {
        $demande = DemandesDocuments::findOrFail($id);
        $demande->delete();

        return redirect()->route('responsable.documents.index')->with('success', 'Demande supprimée.');
    }

    public function create()
    {
        $formations = Formation::all();
        $filieres = Filiere::all();
        $classes = Classe::all();

        return view('document', compact('formations', 'filieres', 'classes'));
    }
  public function terminerDemande(Request $request, $id)
{
    $demande = DemandesDocuments::findOrFail($id);

    // Mettre à jour le statut
    $demande->etat_demande = 'termine';
    $demande->save();

    // Générer l'URL du fichier s'il existe
    $fichierUrl = $demande->fichier ? asset('storage/documents/' . $demande->fichier) : null;

    // Envoyer la notification avec le lien du fichier
    $demande->etudiant->notify(new DocumentPretNotification($demande, $fichierUrl));

    return redirect()->back()->with('success', 'Demande terminée et étudiant notifié.');
}
}
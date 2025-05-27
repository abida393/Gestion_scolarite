<?php
namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Models\DemandesDocuments;
use App\Models\Filiere;
use App\Models\Formation;
use App\Models\Classe;
use Illuminate\Support\Facades\Response;
use App\Notifications\DocumentPretNotification;
use Illuminate\Support\Facades\DB;


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
    public function storeDocument(Request $request)
{

    $request->validate([
        'nom_document'   => 'required|string|max:255',
        'type'           => 'required|string|max:255',
        'template_path'  => 'nullable|string|max:255',
        'generable'      => 'nullable',
    ]);

    Document::create([
        'nom_document'  => $request->nom_document,
        'type'          => $request->type,
        'template_path' => "/public/temmplate/".$request->template_path,
        'generable'     => $request->has('generable'),
    ]);

    return redirect()->back()->with('success', 'Document ajouté avec succès.');
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
    $classes = Classe::all();

    // Récupérer l'année académique via la formation de l'étudiant
    $anneeInscription = '';
    if ($etudiant->formation_id) {
        $anneeFormation = DB::table('annee_formations')
            ->join('annee', 'annee_formations.annee_id', '=', 'annee.id')
            ->where('annee_formations.formation_id', $etudiant->formation_id)
            ->orderByDesc('annee.id') // Prend la plus récente
            ->select('annee.annee_debut', 'annee.annee_fin','annee_id')
            ->first();
            // dd($etudiant->formation_id);
        if ($anneeFormation) {
            $anneeInscription = $anneeFormation->annee_debut . '-' . $anneeFormation->annee_fin;
            $annee_id = $anneeFormation->annee_id;
        }
    }

    $demandes = DemandesDocuments::where('id_etudiant', $etudiant->id)
        ->with('document')
        ->latest()
        ->get();

    return view('etudiant.documents', compact('documents', 'demandes', 'classes', 'anneeInscription'));
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
    $demandes = DemandesDocuments::with(['etudiant.filiere', 'etudiant.formation', 'etudiant.classe', 'document'])->get();
    $filieres = Filiere::all();
    $classes = Classe::all();
$documents = Document::all();
return view('responsable.document', compact('demandes', 'filieres', 'classes', 'documents'));
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

    // Si "import", le fichier est requis
    if ($request->input('fichier_option_'.$id, 'import') === 'import' && $request->hasFile('document')) {
        $rules['document'] = 'required|file|mimes:pdf,docx,jpeg,png|max:10240';
    }

    if ($request->etat_demande === 'refus') {
        $rules['justif_refus'] = 'required|string|max:1000';
    }

    $request->validate($rules);

    // Gestion des fichiers et génération
    if ($request->input('fichier_option_'.$id) === 'import' && $request->hasFile('document')) {
        $path = $request->file('document')->store('documents', 'public');
        $demande->fichier = basename($path);
        $demande->etat_demande = 'termine';
    } elseif ($request->input('fichier_option_'.$id) === 'generer' && $demande->document->generable) {
        $generator = new \App\Services\DocumentGenerator();
        $path = $generator->generate($demande);
        $demande->fichier = basename($path);
        $demande->etat_demande = 'termine';
    } else {
        $demande->etat_demande = $request->etat_demande;
    }

    // Gestion du refus
    if ($demande->etat_demande === 'refus') {
        $demande->justif_refus = $request->justif_refus;
    } else {
        $demande->justif_refus = null;
    }

    $demande->save();

    // Notification automatique si terminé
   if ($demande->etat_demande === 'termine') {
    $demande->refresh();
    $fichierUrl = $demande->fichier ? asset('storage/documents/' . $demande->fichier) : null;
    $content = 'Votre document "' . $demande->document->nom_document . '" est prêt. ';
    if ($fichierUrl) {
        $content .= 'Vous pouvez le <a href="' . $fichierUrl . '" target="_blank" style="color:#2563eb;text-decoration:underline;">télécharger ici</a>.';
    } else {
        $content .= 'Vous pouvez le télécharger.';
    }
    app(\App\Http\Controllers\MessageController::class)->sendMessageAutomatique([
        'content' => $content,
        'sender_id' => Auth::guard('responsable')->id(),
        'receiver_id' => $demande->id_etudiant,
    ]);
    $demande->etudiant->notify(new DocumentPretNotification($demande, $fichierUrl));
}
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

    // Préparer le contenu du message
    $content = 'Votre document "' . $demande->document->nom_document . '" est prêt. ';
    if ($fichierUrl) {
        $content .= 'Vous pouvez le <a href="' . $fichierUrl . '" target="_blank" style="color:#2563eb;text-decoration:underline;">télécharger ici</a>.';
    } else {
        $content .= 'Vous pouvez le télécharger.';
    }

    // Envoyer un message dans la messagerie via MessageController
    app(MessageController::class)->sendMessageAutomatique([
        'content' => $content,
        'sender_id' => Auth::guard('responsable')->id(),
        'receiver_id' => $demande->id_etudiant,
    ]);

    // Envoyer la notification avec le lien du fichier
    $demande->etudiant->notify(new DocumentPretNotification($demande, $fichierUrl));

    return redirect()->back()->with('success', 'Demande terminée et étudiant notifié.');
}
public function getMessages($responsableId)
{
    $etudiantId = Auth::guard('etudiant')->id();
    $messages = Message::where(function($q) use ($etudiantId, $responsableId) {
            $q->where('sender_id', $etudiantId)
              ->where('sender_type', 'etudiant')
              ->where('receiver_id', $responsableId)
              ->where('receiver_type', 'responsable');
        })
        ->orWhere(function($q) use ($etudiantId, $responsableId) {
            $q->where('sender_id', $responsableId)
              ->where('sender_type', 'responsable')
              ->where('receiver_id', $etudiantId)
              ->where('receiver_type', 'etudiant');
        })
        ->orderBy('created_at')
        ->get();

    return response()->json($messages);
}
}

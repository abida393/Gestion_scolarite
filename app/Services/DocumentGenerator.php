<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\DemandesDocuments;
use Illuminate\Support\Facades\Storage;

class DocumentGenerator
{
    public function generate(DemandesDocuments $demande)
    {
        $etudiant = $demande->etudiant;
        $document = $demande->document;
        $responsable = $demande->responsable;
 $logoFile = public_path('images/logooo.png');
$type = pathinfo($logoFile, PATHINFO_EXTENSION);
$data = file_get_contents($logoFile);
$logoPath = 'data:image/' . $type . ';base64,' . base64_encode($data);

// Ajout pour le cachet
$cachetFile = public_path('images/casheruniv.png'); // Mets ici le vrai nom de ton fichier cachet
$typeCachet = pathinfo($cachetFile, PATHINFO_EXTENSION);
$dataCachet = file_get_contents($cachetFile);
$cachetPath = 'data:image/' . $typeCachet . ';base64,' . base64_encode($dataCachet);

$template = Storage::disk('public')->get('templates/attestation-scolarite.html');

$content = str_replace([
    '{{NOM}}',
    '{{PRENOM}}',
    '{{MATRICULE}}',
    '{{FORMATION}}',
    '{{FILIERE}}',
    '{{CLASSE}}',
    '{{ANNEE}}',
    '{{DATE}}',
    '{{RESPONSABLE}}',
    '{{LOGO_PATH}}',
    '{{CACHET_IMAGE_PATH}}' // Ajoute ce placeholder
], [
    $etudiant->etudiant_nom,
    $etudiant->etudiant_prenom,
    $etudiant->matricule,
    $etudiant->formation->nom_formation,
    $etudiant->filiere->nom_filiere,
    $etudiant->classe->nom_classe,
    $demande->annee_academique,
    now()->format('d/m/Y'),
    $responsable ? $responsable->nom . ' ' . $responsable->prenom : '',
    $logoPath,
    $cachetPath // Ajoute la variable ici
], $template);
        
        // Générer le PDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Sauvegarder le fichier
       $filename = 'document_'.$demande->id.'_'.time().'.pdf';
$path = 'documents/'.$filename;
Storage::disk('public')->put($path, $dompdf->output()); // <-- Utilise disk('public')
return $filename;
    }
}
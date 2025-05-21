<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Correction de l'import (en haut du fichier)
use App\Models\Demande; // Chemin correct pour Laravel 8+
class DemandesDocuments extends Model
{
    use HasFactory;
    protected $table = 'demandes_documents';

    protected $fillable = [
        'id_etudiant',
        'id_document',
        'annee_academique',
        'fichier',
        'justif_refus',
        'etat_demande',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'id_document');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }

    // public function demande()
    // {
    //     return $this->belongsTo(Demande::class, 'id_demande');
    // }
}



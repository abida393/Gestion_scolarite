<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demandes_documents extends Model
{
    use HasFactory;

    
    protected $table = 'demandes_documents'; // très important vu que le nom de la classe ne suit pas la convention

    protected $fillable = [
        'id_etudiant',
        'id_document',
        'fichier',
        'annee_academique',
        'etat_demande',
    ];

}
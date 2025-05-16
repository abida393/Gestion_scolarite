<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stage extends Model
{
    use HasFactory;
    // Déclare les attributs autorisés pour l'assignation de masse
    protected $fillable = [
        'nom_stage', 'entreprise', 'domaine', 'duree', 'email_entreprise', 'description'
    ];
}

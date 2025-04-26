<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matiere extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_matiere', // Nom de la matière
        'module_id', // ID du module
        'coefficient', // Coefficient de la matière
        'enseignant_id', // ID de l'enseignant
    ];
}

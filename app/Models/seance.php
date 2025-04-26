<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seance extends Model
{
    use HasFactory;
    protected $fillable = [
        'matiere_id', // ID de la matière associée
        'date_seance', // Date de la séance
        'heure_debut', // Heure de début de la séance
        'heure_fin', // Heure de fin de la séance
        'salle', // Salle de la séance
    ];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}

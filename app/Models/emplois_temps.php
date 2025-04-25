<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emplois_temps extends Model
{
    use HasFactory;

    // Nom de la table (optionnel si le nom suit les conventions Laravel)
    protected $table = 'emplois_temps';

    // Colonnes autorisées pour les opérations de création et de mise à jour
    protected $fillable = [
        'jour',
        'date',
        'heure_debut',
        'heure_fin',
        'matiere_id',
        'enseignant_id',
        'salle',
        'classe_id',
    ];

    // Relations avec les autres modèles
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emplois_temps extends Model
{
    use HasFactory;

    protected $table = 'emplois_temps';

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

    public function matiere()
{
    return $this->belongsTo(Matiere::class);
}

public function enseignant()
{
    return $this->belongsTo(Enseignant::class, 'enseignant_id');
}

public function classe()
{
    return $this->belongsTo(Classe::class);
}

}

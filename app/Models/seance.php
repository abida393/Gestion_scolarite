<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seance extends Model
{
    use HasFactory;
    protected $fillable = [
        'matiere_id',
        'date_seance',
        'heure_debut',
        'heure_fin',
        'salle',
    ];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
    public function etudiant_absences()
    {
        return $this->hasMany(etudiant_absence::class, 'seance_id', 'id');
    }
    public function etudiantAbsences()
    {
        return $this->hasMany(EtudiantAbsence::class, 'seance_id', 'id');
    }

}

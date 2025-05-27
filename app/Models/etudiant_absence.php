<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etudiant_absence extends Model
{
    use HasFactory;

    protected $table = 'etudiant_absences';
    protected $dates = ['date_absence', 'date_justif'];

   protected $fillable = [
    'emploi_temps_id',
    'etudiant_id',
    'date_absence',
    'date_justif',
    'type',
    'duree_minutes',
    'Justifier',
    'justification',
    'justification_file',
    'status', // Ajouté
];

    public function seance()
    {
        return $this->belongsTo(seance::class, 'seance_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(etudiant::class, 'etudiant_id');
    }

    public function classe()
{
    return $this->belongsTo(Classe::class, 'classe_id');
}
    public function emploiTemps()
    {
        return $this->belongsTo(emplois_temps::class, 'emploi_temps_id');
    }
    public function matiere()
    {
        return $this->belongsTo(matiere::class, 'matiere_id');
    }

    // Uncomment if you need to define a relationship with the Etudiant model

public function etudiants()
{
    return $this->hasMany(Etudiant::class);
}

}

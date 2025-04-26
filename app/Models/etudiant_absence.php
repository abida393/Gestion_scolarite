<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etudiant_absence extends Model
{
    protected $table = 'etudiant_absences';
    use HasFactory;
    protected $fillable = [
        'seance_id', // ID de la séance associée
        'date_justif', // Date de justification de l'absence
        'justification', // Texte de justification
        'justifier', // Booléen 0 ou 1
    ];

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }
}

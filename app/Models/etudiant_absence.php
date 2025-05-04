<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etudiant_absence extends Model
{
    use HasFactory;

    protected $table = 'etudiant_absences';

    protected $fillable = [
        'seance_id',
        'etudiant_id',
        'date_justif',
        'justification',
        'justifier',
        'justification_file', // Ajout de la colonne pour le fichier PDF
    ];

    public function seance()
    {
        return $this->belongsTo(seance::class, 'seance_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(etudiant::class, 'etudiant_id');
    }
}
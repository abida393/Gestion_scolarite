<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etudiant_absence extends Model
{
  // Assurez-vous que la table est bien définie ici
    use HasFactory;
// Dis à Laravel la table exacte
protected $table = 'etudiant_absences';

protected $fillable = [
    'seance_id',
    'etudiant_id',
    'date_justif',
    'justification',
    'justifier',
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

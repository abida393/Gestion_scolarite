<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $fillable = [
        'etudiant_id',
        'matiere_id',
        'examen_id',
        'note'
    ];
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function examen()
    {
    return $this->belongsTo(Examen::class);
    }

}

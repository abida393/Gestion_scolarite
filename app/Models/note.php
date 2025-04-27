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
}

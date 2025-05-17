<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $table = 'notes';
    protected $fillable = [
        'etudiant_id',
        'matiere_id',
        'note1',
        'note2',
    ];

    public function etudiant()
    {
        return $this->belongsTo(etudiant::class, 'etudiant_id');
    }
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function examen()
    {
    return $this->belongsTo(Examen::class);
    }

}

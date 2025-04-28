<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matiere extends Model
{
    use HasFactory;
    protected $table = 'matieres';
    protected $fillable = [
        'nom_matiere',
        'module_id',
        'coefficient',
        'enseignant_id',
    ];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function examens()
    {
        return $this->hasMany(Examen::class);
    }
    public function seances()
    {
        return $this->hasMany(Seance::class, 'matiere_id', 'id');
    }
    public function emploisTemps()
    {
        return $this->hasMany(emplois_temps::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}

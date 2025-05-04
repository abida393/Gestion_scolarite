<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $table = 'formations';


    protected $fillable = [
        'nom_formation',
        'description',
        'diplome',
        'niveau',
        'filiere_id',
    ];
    public function etudiants()
    {
        return $this->hasMany(etudiant::class, 'formation_id');
    }
    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }
    public function responsables()
    {
        return $this->hasMany(Responsable::class, 'formation_id', 'id');
    }
    public function annee_formation()
    {
        return $this->hasMany(annee_formation::class, 'formation_id', 'id');
    }
}

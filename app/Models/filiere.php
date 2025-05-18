<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $table = 'filieres';


    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
    public function classes()
    {
        return $this->hasMany(classe::class,"filieres_id");
    }
    /*public function etudiants()  //Version qdima
    {
        return $this->hasMany(Etudiant::class, 'filiere_id', 'id');
    }*/
    // app/Models/Filiere.php

public function matieres()
{
    return $this->hasMany(Matiere::class, 'filiere_id');
}

// App\Models\Filiere.php
public function modules()
{
    return $this->hasMany(Module::class);
}

public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}

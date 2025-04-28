<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enseignant extends Model
{
    use HasFactory;
    protected $table = 'enseignants';

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
    public function emploisTemps()
    {
        return $this->hasMany(emplois_temps::class);
    }
}

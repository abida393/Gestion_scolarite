<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe extends Model
{
    use HasFactory;
    protected $table = 'classes';
    public function filieres()
    {
        return $this->belongsTo(filiere::class);
    }
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'classes_id', 'id');
    }
    public function emploisTemps()
    {
        return $this->hasMany(emplois_temps::class);
    }
}

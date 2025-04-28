<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $fillable = ['nom_matiere', 'module_id', 'coefficient', 'enseignant_id'];

    public function getNameAttribute()
    {
        return $this->attributes['nom_matiere'];
    }
}
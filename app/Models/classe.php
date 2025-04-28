<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = ['nom_classe', 'filieres_id'];

    public function getNameAttribute()
    {
        return $this->attributes['nom_classe'];
    }
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filieres_id');
    }
}
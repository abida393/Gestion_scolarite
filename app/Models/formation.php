<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $table = 'formations'; // Assurez-vous que le nom de la table est correct

    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }
}

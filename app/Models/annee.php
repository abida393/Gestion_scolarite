<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class annee extends Model
{
    use HasFactory;

    protected $table = 'annee'; // Assurez-vous que le nom de la table est correct

    protected $fillable = ['libelle']; // Ajoutez 'libelle' ici pour permettre l'insertion de données

    public function annee_formation()
    {
        return $this->hasMany(annee_formation::class, 'annee_id', 'id');
    }
}
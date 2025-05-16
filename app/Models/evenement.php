<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evenement extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'date',
        'heure_debut',
        'heure_fin',
    ];
}

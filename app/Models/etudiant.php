<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class etudiant extends Authenticatable
{
    use HasFactory , Notifiable, HasApiTokens;
    protected $table = 'etudiants';
    protected $fillable = [
        'nom',
        'prenom',
        'email_ecole',
        'password',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'photo',
        'sexe',
        'filiere_id',
        'niveau_id',
    ];
}

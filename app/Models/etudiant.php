<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class etudiant extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
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

    // Add this method to ensure proper email handling
    public function getEmailForPasswordReset()
    {
        return $this->email_ecole;
    }

    // This ensures the model can provide an email attribute
    public function getEmailAttribute()
    {
        return $this->email_ecole;
    }


    
    public function formation()
    {
        return $this->belongsTo(formation::class, 'formation_id');
    }
    public function profile()
    {
        return $this->belongsTo(profile::class, 'type_profile', 'type_profile');
    }

    public function classe()
    {
        return $this->belongsTo(classe::class, 'classes_id', 'id');
    }

    public function filiere()
    {
        return $this->belongsTo(filiere::class, 'filiere_id', 'id');
    }
    public function etudiant_absences()
    {
        return $this->hasMany(etudiant_absence::class, 'etudiant_id');
    }
    public function documents()
    {
        return $this->belongsToMany(document::class, 'demandes_documents', 'id_etudiant', 'id_document')
            ->withPivot('etat_demande')
            ->withTimestamps();
    }
    public function paiements()
    {
        return $this->hasMany(paiement::class);
    }
}

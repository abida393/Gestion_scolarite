<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class etudiant extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'etudiants';
    /*protected $fillable = [
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
    ];*/
    protected $fillable = [
        'type_profile', 'formation_id', 'classes_id', 'filiere_id', 'email_ecole', 'password', 
        'identifiant', 'etudiant_cin', 'etudiant_serie_bac', 'etudiant_cne', 'etudiant_session_bac', 
        'etudiant_mention_bac', 'annee_obtention_bac', 'etudiant_nom', 'etudiant_prenom', 
        'etudiant_date_naissance', 'etudiant_lieu_naissance', 'etudiant_sexe', 'etudiant_nationalite',
        'PHOTOS', 'etudiant_adresse', 'etudiant_code_postal', 'DOSSIERCOMPLET', 'ville', 'etudiant_tel', 
        'etudiant_email', 'nom_pere', 'prenom_pere', 'fonction_pere', 'telephone_pere', 'cnss', 'nom_mere', 
        'prenom_mere', 'fonction_mere', 'telephone_mere'
    ];

    public function getEmailForPasswordReset()
    {
        return $this->email_ecole;
    }

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
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    // app/Models/Etudiant.php

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_etudiant');
    }
    public function totalRetardMinutes($periode = 'month')
{
    return $this->absences()
        ->where('type', 'retard')
        ->whereBetween('date_absence', [now()->startOfMonth(), now()->endOfMonth()])
        ->sum('duree_minutes');
}
public function absences()
{
    return $this->hasMany(etudiant_absence::class, 'etudiant_id');
}
    // public function getNomAttribute()
    // {
    //     return $this->attributes['etudiant_nom']; // Accède à 'etudiant_nom'
    // }

    // public function getPrenomAttribute()
    // {
    //     return $this->attributes['etudiant_prenom']; // Accède à 'etudiant_prenom'
    // }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enseignant extends Model
{
    use HasFactory;
    protected $fillable = [
        'enseignant_nom', 'enseignant_prenom', 'enseignant_sexe', 'enseignant_nationalite',
        'enseignant_cin', 'enseignant_cnss', 'enseignant_diplomes', 'enseignant_specialite',
        'enseignant_date_naissance', 'enseignant_lieu_naissance', 'enseignant_tel',
        'enseignant_adresse_postale', 'enseignant_email', 'enseignant_contrat',
        'enseignant_date_embauche', 'enseignant_salaire', 'enseignant_permanent_vacataire',
        'enseignant_fonction_principale', 'enseignant_employeur_principal',
        'enseignant_type_paiement', 'enseignant_banque', 'enseignant_rib'
    ];

    public function getNameAttribute()
    {
        return $this->attributes['enseignant_nom'] . ' ' . $this->attributes['enseignant_prenom'];
    }

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

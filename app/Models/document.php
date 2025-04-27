<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    public function etudiants()
    {
        return $this->belongsToMany(etudiant::class, 'demandes_documents', 'id_document', 'id_etudiant')
            ->withPivot('etat_demande')
            ->withTimestamps();
    }
}

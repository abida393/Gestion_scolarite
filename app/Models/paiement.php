<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'montant_total',
        'montant_paye',
        'montant_restant',
        'mode_paiement',
        'numero_cheque',
        'date_paiement',
        'status',
    ];

    /**
     * Relation avec l'étudiant
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}

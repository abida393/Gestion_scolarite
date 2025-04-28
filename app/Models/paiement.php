<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    use HasFactory;
    protected $table = 'paiements';
    public function etudiant()
    {
        return $this->belongsTo(etudiant::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    use HasFactory;
    protected $table = 'notes';

    public function etudiant()
    {
        return $this->belongsTo(etudiant::class, 'etudiant_id');
    }
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }   
}

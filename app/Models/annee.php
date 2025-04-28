<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class annee extends Model
{
    use HasFactory;
    protected $table = 'annee';
    public function annee_formation()
    {
        return $this->hasMany(annee_formation::class, 'annee_id', 'id');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class module extends Model
{
    use HasFactory;
    protected $table = 'modules';

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
    public function periodes()
    {
        return $this->hasMany(periode::class);
    }
}

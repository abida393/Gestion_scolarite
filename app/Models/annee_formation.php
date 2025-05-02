<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class annee_formation extends Model
{
    use HasFactory;
    protected $table = 'annee_formations';
    public function annee()
    {
        return $this->belongsTo(Annee::class, 'annee_id', 'id');
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class examen extends Model
{
    use HasFactory;
    protected $table = 'examens';
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

public function notes()
{
    return $this->hasMany(Note::class);
}

}

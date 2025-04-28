<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    public function responsables()
    {
        return $this->hasMany(Responsable::class, 'type_profile', 'type_profile');
    }
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'type_profile', 'type_profile');
    }
}

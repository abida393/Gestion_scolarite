<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
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
    /*public function filiere()    //Version qdima
{
    return $this->belongsTo(filiere::class, 'filiere_id');
}
*/

  public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
    public function classes()
    {
        return $this->hasMany(Classe::class);
    }
}

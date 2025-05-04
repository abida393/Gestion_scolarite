<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['etudiant_id', 'sender', 'content'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}

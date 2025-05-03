<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversation extends Model
{
    use HasFactory;
    // Conversation.php
    public function messages()
    {
        return $this->hasMany(message::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(etudiant::class);
    }

    public function responsable()
    {
        return $this->belongsTo(responsable::class);
    }
}

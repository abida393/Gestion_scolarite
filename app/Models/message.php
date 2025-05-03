<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory;
    // Message.php
    public function conversation()
    {
        return $this->belongsTo(conversation::class);
    }

    public function sender()
    {
        return $this->morphTo();
    }
}

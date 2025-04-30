<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class responsable extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'responsables';
    public function getEmailForPasswordReset()
    {
        return $this->email_ecole;
    }

    public function getEmailAttribute()
    {
        return $this->email_ecole;
    }



    public function profile()
    {
        return $this->belongsTo(Profile::class, 'type_profile', 'type_profile');
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'sender_id', 'sender_type', 'receiver_id', 'receiver_type',
    ];
    public function sender()
    {
        return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    }

    public function receiver()
    {
        return $this->morphTo(__FUNCTION__, 'receiver_type', 'receiver_id');
    }
}

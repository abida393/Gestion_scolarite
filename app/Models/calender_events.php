<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calender_events extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'is_fixed',
    ];
    protected $table = 'calender_events';
   

    public function calenders()
    {
        return $this->hasMany(Calender::class, 'calendar_event_id');
    }
}

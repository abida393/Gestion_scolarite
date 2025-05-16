<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calender extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'calendar_event_id',
        'annee_id',
        'start_date',
        'end_date',
    ];

    // Dans app/Models/Calender.php

    protected $table = 'calenders';

    public function event()
    {
        return $this->belongsTo(calender_events::class, 'calendar_event_id');
    }

}


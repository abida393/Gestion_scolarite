<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class periode extends Model
{
    use HasFactory;
    protected $table = 'periodes';
    public function module()
    {
        return $this->belongsTo(module::class);
    }
}

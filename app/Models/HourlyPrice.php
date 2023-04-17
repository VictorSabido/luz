<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourlyPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_id',
        'hour',
        'time_slot',
        'pcb',
        'cym',
    ];
}

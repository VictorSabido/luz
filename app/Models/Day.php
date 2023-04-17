<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_date',
    ];

    public function hourlyPrices()
    {
        return $this->hasMany(HourlyPrice::class);
    }
}
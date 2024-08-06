<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'seat_number', 'status'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}

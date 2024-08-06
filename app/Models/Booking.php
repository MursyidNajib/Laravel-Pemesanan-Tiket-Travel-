<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'customer_name', 'customer_email', 'customer_address', 'customer_phone', 'total_passengers', 'total_price', 'status'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
}

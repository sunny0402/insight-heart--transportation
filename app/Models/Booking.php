<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    // TODO: causes error at booking/index.blade.php
    // relationship between Booking and User model
    public function fromBookingToUserTable()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

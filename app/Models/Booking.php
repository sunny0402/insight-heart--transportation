<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    // relationship between Booking and User model
    public function fromBookingToUser()
    {
        return $this->belongsTo(User::class);
    }
}

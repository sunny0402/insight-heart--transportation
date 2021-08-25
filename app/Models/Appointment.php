<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Time;

class Appointment extends Model
{
    // use HasFactory;

    // whatever info comes from the form save in the database
    protected $guarded = [];

    public function userIdToId()
    {
        // appointments table has user_id
        // users table has id
        // this function will take us from appointments table to users table
        return  $this->belongsTo(User::class, 'user_id', 'id');
    }
}

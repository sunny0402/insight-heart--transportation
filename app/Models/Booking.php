<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\MissingUser;

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
    //modified relationship to deal with missing user, so a deleted user would not result in
    //“Trying to get property ‘id’ of non-object”
    // id set to user_id as defined in Booking model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->withDefault(MissingUser::make(['id' => $this->user_id])->toArray());
    }
}

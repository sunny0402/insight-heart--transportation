<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'pick_up',
    //     'drop_off',
    //     'appointmentNum'
    // ];

    // whatever info comes from the form save in the database
    protected $guarded = [];
}

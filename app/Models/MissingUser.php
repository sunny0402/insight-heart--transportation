<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MissingUser extends User
{
    use HasFactory;
    protected static $unguarded = true;

    // TODO:missing image
    protected $attributes = [
        'name'  => 'missing name',
        'email' => 'missing email',
        'phone_number' => 'missing phone number',
    ];
}

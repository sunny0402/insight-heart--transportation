<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'license_plate',
        'vehicle_info',
        'address',
        'region',
        'phone_number',
        'image',
        'role_id',
        'description'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // defines relationship between User and Role models
    // with this method can call properties of role model role->name
    public function role()
    {
        // id from the roles table is a foreign key, role_id, in users table
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public function userAvatar($request)
    {
        $image = $request->file('image');
        $name = $image->hashName();
        $destination = public_path('/images');
        $image->move($destination, $name);
        return $name;
    }
}

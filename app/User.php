<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'user_name',
        'password',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'role',
        'ad_sense_snippet',
    ];

    public $timestamps = false;

    /**
     * Hashes any password that is to be registered to a user
     * 
     * @param Mixed $password the password to be hashed
     * @return none
     */
    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function posts() 
    {
        return $this->belongsToMany('App\Post');
    }

    public function getJWTIdentifier() 
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims() 
    {
        return [];
    }
}

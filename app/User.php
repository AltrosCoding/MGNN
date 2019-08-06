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
        'ad_sense_snippet',
    ];

    protected $hidden = [
        'pivot',
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

    public function can($ability, $arguments = []): bool
    {
        return $this->roles()->where($ability, true)->count() > 0;
    }

    public function cannot($ability, $arguments = []): bool
    {
        return $this->roles()->where($ability, true)->count() === 0;
    }

    public function posts() 
    {
        return $this->belongsToMany('App\Post');
    }

    public function published()
    {
        return $this->belongsToMany('App\Post')
                ->where('posts.status', '=', 'published')
                ->select([
                    'id',
                    'title',
                    'excerpt',
                ]);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role')
                ->select([
                    'id',
                    'name',
                ]);
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

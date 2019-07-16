<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model
{
    protected $fillable = [
        'user_name',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'role',
        'ad_sense_snippet',
    ];

    public function posts() {
        return $this->hasManyThrough(
            'App\Post', 
            'App\UserPost', 
            'user_id',
            'id',
            'id',
            'post_id'
        );
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}

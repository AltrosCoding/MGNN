<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
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

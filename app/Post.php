<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user() {
        return $this->hasOneThrough(
            'App\User', 
            'App\UserPost',
            'post_id',
            'id',
            'id',
            'user_id'
        );
    }
}

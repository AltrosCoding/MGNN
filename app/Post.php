<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tag',
        'status',
        'scheduled_at',
    ];

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

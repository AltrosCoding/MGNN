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

    public function users() {
        return $this->belongsToMany('App\User');
    }
}

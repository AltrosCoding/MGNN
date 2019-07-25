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
        return $this
                ->belongsToMany('App\User')
                ->select([
                    'id',
                    'user_name',
                    'first_name',
                    'last_name',
                    'role',
                    'exp',
                    'level',
                    'ad_sense_snippet',
                ]);
    }
}

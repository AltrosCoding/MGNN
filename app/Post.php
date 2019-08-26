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
        'published_at',
    ];

    protected $hidden = [
        'pivot',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function users() {
        return $this
                ->belongsToMany('App\User')
                ->select([
                    'id',
                    'user_name',
                    'first_name',
                    'last_name',
                    'exp',
                    'level',
                    'ad_sense_snippet',
                ]);
    }

    public function schedule()
    {
        return $this->hasOne('App\PostSchedule')->withDefault([
            'scheduled_at' => null,
        ]);
    }
}

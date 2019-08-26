<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostSchedule extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'scheduled_at',
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}

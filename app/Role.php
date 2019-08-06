<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'create_comment',
        'create_article',
        'create_role',
        'create_user',
        'edit_comment',
        'edit_article',
        'edit_role',
        'edit_user',
        'delete_comment',
        'delete_article',
        'delete_role',
        'delete_user',
        'invite_author',
        'revoke_author',
        'schedule_article',
        'run_article',
        'view_pending',
        'permalink',
    ];

    protected $hidden = [
        'pivot',
    ];

    public function users()
    {
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
}

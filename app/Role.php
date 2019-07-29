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
                    'role',
                    'exp',
                    'level',
                    'ad_sense_snippet',
                ]);
    }
}

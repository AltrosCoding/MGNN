<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::create([
            'name' => 'Admin',
            'create_comment' => true,
            'create_article' => true,
            'create_role' => true,
            'create_user' => true,
            'edit_comment' => true,
            'edit_article' => true,
            'edit_role' => true,
            'edit_user' => true,
            'delete_comment' => true,
            'delete_article' => true,
            'delete_role' => true,
            'delete_user' => true,
            'invite_author' => true,
            'revoke_author' => true,
            'schedule_article' => true,
            'run_article' => true,
            'view_pending' => true,
            'permalink' => true,
        ]);

        \App\Role::create([
            'name' => 'Banned',
            'create_comment' => false,
            'create_article' => false,
            'create_role' => false,
            'create_user' => false,
            'edit_comment' => false,
            'edit_article' => false,
            'edit_role' => false,
            'edit_user' => false,
            'delete_comment' => false,
            'delete_article' => false,
            'delete_role' => false,
            'delete_user' => false,
            'invite_author' => false,
            'revoke_author' => false,
            'schedule_article' => false,
            'run_article' => false,
            'view_pending' => false,
            'permalink' => false,
        ]);
        
        \App\Role::create([
            'name' => 'User',
            'create_comment' => true,
            'create_article' => false,
            'create_role' => false,
            'create_user' => false,
            'edit_comment' => false,
            'edit_article' => false,
            'edit_role' => false,
            'edit_user' => false,
            'delete_comment' => false,
            'delete_article' => false,
            'delete_role' => false,
            'delete_user' => false,
            'invite_author' => false,
            'revoke_author' => false,
            'schedule_article' => false,
            'run_article' => false,
            'view_pending' => false,
            'permalink' => false,
        ]);

        \App\Role::create([
            'name' => 'Contributor',
            'create_comment' => true,
            'create_article' => true,
            'create_role' => false,
            'create_user' => false,
            'edit_comment' => false,
            'edit_article' => false,
            'edit_role' => false,
            'edit_user' => false,
            'delete_comment' => false,
            'delete_article' => false,
            'delete_role' => false,
            'delete_user' => false,
            'invite_author' => false,
            'revoke_author' => false,
            'schedule_article' => false,
            'run_article' => false,
            'view_pending' => false,
            'permalink' => false,
        ]);

        \App\Role::create([
            'name' => 'Jr. Editor',
            'create_comment' => true,
            'create_article' => false,
            'create_role' => false,
            'create_user' => false,
            'edit_comment' => false,
            'edit_article' => true,
            'edit_role' => false,
            'edit_user' => false,
            'delete_comment' => false,
            'delete_article' => false,
            'delete_role' => false,
            'delete_user' => false,
            'invite_author' => false,
            'revoke_author' => false,
            'schedule_article' => false,
            'run_article' => false,
            'view_pending' => true,
            'permalink' => false,
        ]);

        \App\Role::create([
            'name' => 'Sr. Editor',
            'create_comment' => true,
            'create_article' => false,
            'create_role' => false,
            'create_user' => false,
            'edit_comment' => false,
            'edit_article' => true,
            'edit_role' => false,
            'edit_user' => false,
            'delete_comment' => false,
            'delete_article' => true,
            'delete_role' => false,
            'delete_user' => false,
            'invite_author' => false,
            'revoke_author' => false,
            'schedule_article' => true,
            'run_article' => true,
            'view_pending' => true,
            'permalink' => false,
        ]);

        \App\Role::create([
            'name' => 'Social Media',
            'create_comment' => true,
            'create_article' => false,
            'create_role' => false,
            'create_user' => false,
            'edit_comment' => false,
            'edit_article' => false,
            'edit_role' => false,
            'edit_user' => false,
            'delete_comment' => false,
            'delete_article' => false,
            'delete_role' => false,
            'delete_user' => false,
            'invite_author' => false,
            'revoke_author' => false,
            'schedule_article' => false,
            'run_article' => false,
            'view_pending' => true,
            'permalink' => true,
        ]);

        \App\Role::create([
            'name' => 'Web Dev',
            'create_comment' => true,
            'create_article' => false,
            'create_role' => false,
            'create_user' => false,
            'edit_comment' => false,
            'edit_article' => false,
            'edit_role' => false,
            'edit_user' => false,
            'delete_comment' => false,
            'delete_article' => false,
            'delete_role' => false,
            'delete_user' => false,
            'invite_author' => false,
            'revoke_author' => false,
            'schedule_article' => false,
            'run_article' => false,
            'view_pending' => false,
            'permalink' => false,
        ]);
    }
}

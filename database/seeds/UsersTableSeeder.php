<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 50)->create();

        \App\User::where('role', '=', 'writer')
        ->get()
        ->each(function ($user) {
            $posts = factory(\App\Post::class, rand(0, 3))->create();
            $user->posts()->attach($posts->pluck('id'));
        });
    }
}

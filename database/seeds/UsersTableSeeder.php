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
        factory(\App\User::class, 10)
        ->create()
        ->each(function ($user) {
            factory(\App\Post::class, rand(0, 3))
            ->create()
            ->each(function ($post) use ($user) {
                $user->posts()->attach($post->id);
            });
        });
    }
}

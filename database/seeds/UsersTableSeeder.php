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

        $roles = \App\Role::all()->pluck('id')->toArray();

        \App\User::all()->each(function ($user) use ($roles) {
            $history = array();
            $toAdd = array();

            for ($i = rand(1, 3); $i; --$i) {
                $rand;

                do {
                    $rand = array_rand($roles);
                } while (in_array($rand, $history));

                array_push($history, $rand);
                array_push($toAdd, $roles[$rand]);
            }

            $user->roles()->attach($toAdd);
        });

        \App\User::whereHas('roles', function (Illuminate\Database\Eloquent\Builder $query) {
            $query->where('name', '=', 'Contributor');
        })
        ->get()
        ->each(function ($user) {
            $posts = factory(\App\Post::class, rand(0, 3))->create();
            $user->posts()->attach($posts->pluck('id'));
        });
    }
}

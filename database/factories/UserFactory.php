<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'user_name' => $faker->unique()->firstName,
        'password' => 'password',
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birth_date' => $faker->date,
        'email' => $faker->unique()->safeEmail,
        'is_confirmed' => $faker->numberBetween(0, 1),
        'role' => $faker->randomElement(Config::get('constants.roles')),
    ];
});

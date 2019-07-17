<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->text(100),
        'excerpt' => $faker->paragraph,
        'content' => $faker->paragraphs(3, true),
        'featured_image' => $faker->imageUrl(640, 480, 'cats'),
        'category' => $faker->text(100),
        'tag' => $faker->text(1000),
        'status' => $faker->randomElement(Config::get('constants.statuses')),
    ];
});

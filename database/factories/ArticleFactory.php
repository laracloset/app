<?php

use Faker\Generator as Faker;

$factory->define(\App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'slug' => $faker->unique()->slug,
        'body' => $faker->sentence,
        'state' => \App\Article::PUBLISHED
    ];
});

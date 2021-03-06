<?php

use Faker\Generator as Faker;

$factory->define(\App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'slug' => $faker->unique()->slug(),
        'body' => $faker->sentence(100),
        'state' => \App\Article::PUBLISHED
    ];
});

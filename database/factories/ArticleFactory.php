<?php

use Faker\Generator as Faker;

$factory->define(\App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'slug' => $faker->unique()->slug(),
        'body' => $faker->sentence(100),
        'state' => \App\Article::PUBLISHED
    ];
});

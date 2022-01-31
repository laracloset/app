<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'slug' => $faker->unique()->slug(),
        'body' => $faker->sentence(100),
        'state' => $faker->randomElement(\App\Enums\PostStatus::getValues())
    ];
});

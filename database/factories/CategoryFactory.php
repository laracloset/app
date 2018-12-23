<?php

use Faker\Generator as Faker;

$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'slug' => $faker->unique()->slug(),
        'parent_id' => $faker->randomDigit(),
    ];
});

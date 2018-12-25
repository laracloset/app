<?php

use Faker\Generator as Faker;

$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'slug' => $faker->unique()->slug(),
    ];
});

$factory->state(\App\Category::class, 'child', function (Faker $faker) {
    return [
        'parent_id' => factory(\App\Category::class)->create()->id,
    ];
});

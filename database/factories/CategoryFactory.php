<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(),
        'slug' => $faker->unique()->slug(),
    ];
});

$factory->state(\App\Models\Category::class, 'child', function (Faker $faker) {
    return [
        'parent_id' => factory(\App\Models\Category::class)->create()->id,
    ];
});

<?php

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

$factory->define(\App\Asset::class, function (Faker $faker) {
    $file = UploadedFile::fake()->image('avatar.jpg');
    $path = $file->store('assets');

    return [
        'model' => 'Asset',
        'name' => $file->getClientOriginalName(),
        'type' => $file->getMimeType(),
        'size' => $file->getSize(),
        'path' => $path,
    ];
});

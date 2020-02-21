<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\File;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    return [
        'filename' => Str::random(12) . '.jpg',
        'path' => '/images',
        'size' => $faker->numberBetween(1024 * 1024, 5 * 1024 * 1024),
    ];
});

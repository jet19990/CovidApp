<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vaccination;
use Faker\Generator as Faker;

$factory->define(Vaccination::class, function (Faker $faker) {
    return [
        'uid' => $faker->unique()->numberBetween($min = 1, $max = 1001),
        'vaccine' => $faker->randomElement(['A', 'B']),
        'dose' => $faker->randomElement([0.5, 1.0]),
        'test' => $faker->boolean
    ];
});

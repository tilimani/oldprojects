<?php

use Faker\Generator as Faker;

$factory->define(App\Nationality::class, function (Faker $faker) {
    return [
        'description' => $faker->country
    ];
});

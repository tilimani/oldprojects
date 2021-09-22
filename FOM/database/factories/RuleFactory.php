<?php

use Faker\Generator as Faker;

$factory->define(App\Rule::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->numberBetween(0, 20),
    ];
});

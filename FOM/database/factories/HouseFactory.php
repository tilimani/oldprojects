<?php

use Faker\Generator as Faker;

$factory->define(App\House::class, function (Faker $faker) {
    return [
        'name' => $faker->streetAddress,
        'address' => $faker->streetAddress,
        'description' => $faker->realText(random_int(12, 16)),
        'neighborhood_id' => function () {
            return factory(App\Neighborhood::class)->create()->id;
        },
    ];
});
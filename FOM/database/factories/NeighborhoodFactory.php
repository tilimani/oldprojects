<?php

use Faker\Generator as Faker;

$factory->define(App\Neighborhood::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'location_id' => function () {
            return factory(App\Location::class)->create()->id;
        },
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'city_id' => function () {
            return factory(App\City::class)->create()->id;
        }
    ];
});

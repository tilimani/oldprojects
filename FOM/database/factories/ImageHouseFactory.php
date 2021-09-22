<?php

use Faker\Generator as Faker;

$factory->define(App\ImageHouse::class, function (Faker $faker) {
    return [
        'path' => $faker->imageUrl(300, 300, 'people'),
        'house_id' => 4,
    ];
});

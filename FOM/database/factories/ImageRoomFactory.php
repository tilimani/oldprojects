<?php

use Faker\Generator as Faker;

$factory->define(App\ImageRoom::class, function (Faker $faker) {
    return [
        'path' => $faker->imageUrl(300, 300, 'people'),
        'room_id' => 3
    ];
});

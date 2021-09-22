<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function (Faker $faker) {
    return [
        'name' => $faker->name.random_int(1, 64),
        'description' => $faker->realText(random_int(16, 256)),
        'house_id' => function () {
            return factory(App\House::class)->create()->id;
        },
    ];
});

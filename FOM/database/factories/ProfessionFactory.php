<?php

use Faker\Generator as Faker;

$factory->define(App\Profession::class, function (Faker $faker) {
    return [
        'description' => $faker->realText(random_int(16, 32))
    ];
});
